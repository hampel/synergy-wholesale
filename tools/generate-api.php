<?php

declare(strict_types=1);

/**
 * Generates the typed API surface from the pinned WSDL.
 *
 * Run with `composer generate`. The output is committed, so consumers never
 * need this script and a diff shows exactly what changed when Synergy
 * Wholesale publishes a new WSDL. CI regenerates and fails if the tree is
 * stale.
 *
 * Two things about the source WSDL drove the design here, and both would fail
 * silently if assumed away:
 *
 *  1. Request and response types are NOT reliably named after their operation,
 *     and several are shared between operations -- listDomains returns
 *     bulkDomainInfoResponse, hostingEnableTempUrl takes
 *     hostingGetServiceRequest. Everything therefore resolves through
 *     portType -> message -> part type, never by name convention.
 *
 *  2. minOccurs is not trustworthy. For transferDomain the WSDL marks
 *     organisation, fax, idProtect and doRenewal as required while the
 *     published PDF documents the last two as optional and never mentions the
 *     first two at all. Requests are therefore biased toward optional: see
 *     REQUIRED_OVERRIDES.
 */

const NS = 'Hampel\\SynergyWholesale';

$root = dirname(__DIR__);
$wsdl = $root . '/resources/wsdl.xml';
$out = $root . '/src/Generated';

/**
 * Fields the WSDL marks required that the published documentation contradicts.
 *
 * Biasing toward optional is deliberate and asymmetric: a field wrongly marked
 * optional produces an ERR_ response the caller can read and correct, while a
 * field wrongly marked required makes a valid call impossible to express.
 *
 * Keyed by request type, then field name.
 */
const REQUIRED_OVERRIDES = [
    'transferDomainRequest' => [
        'organisation' => false,
        'fax' => false,
        'idProtect' => false,
        'doRenewal' => false,
    ],
    'domainRegisterRequest' => [
        // Both documented Optional; the WSDL marks them required.
        'idProtect' => false,
        'specialConditionsAgree' => false,
    ],
];

/**
 * The four contact blocks that appear identically across domainRegister,
 * updateContact and the deprecated register variants: 11 fields each, prefixed
 * with the contact role. Collapsing them turns domainRegister's 57 parameters
 * into 13 plus four Contact objects.
 */
const CONTACT_ROLES = ['registrant', 'technical', 'admin', 'billing'];
const CONTACT_FIELDS = [
    'organisation', 'firstname', 'lastname', 'address', 'suburb',
    'state', 'country', 'postcode', 'phone', 'fax', 'email',
];

/**
 * Operations Synergy Wholesale deprecated in API v3.4 (February 2020). They
 * still exist in the WSDL and still answer, but the registry-specific register
 * and transfer calls were replaced by domainRegister plus the eligibility
 * commands. Generating them would be generating a trap.
 */
const DEPRECATED = [
    'domainRegisterAU',
    'domainRegisterUK',
    'domainRegisterUS',
    'domainTransferUK',
    'resubmitFailedTransfer',
];

/** Every request carries these; the transport injects them. */
const AUTH_FIELDS = ['resellerID', 'apiKey'];

/**
 * Every operation's response carries these, and Client consumes them as the
 * envelope before the response class is built.
 *
 * Top-level responses only. Eleven nested types declare a field of the same name,
 * and there it is data: a per-entry result on bulkDomainInfo, the certificate's
 * state on SSL_listAllCerts, the client's on listClients.
 */
const ENVELOPE_FIELDS = ['status', 'errorMessage'];

// ---------------------------------------------------------------------------
// Parse
// ---------------------------------------------------------------------------

$xml = file_get_contents($wsdl);
if ($xml === false) {
    fwrite(STDERR, "Cannot read {$wsdl}\n");
    exit(1);
}

$doc = new DOMDocument();
$doc->loadXML($xml);
$xp = new DOMXPath($doc);
$xp->registerNamespace('wsdl', 'http://schemas.xmlsoap.org/wsdl/');
$xp->registerNamespace('xsd', 'http://www.w3.org/2001/XMLSchema');

/** message name => part type (local name, tns: stripped) */
$messages = [];
foreach ($xp->query('//wsdl:message') as $m) {
    $part = $xp->query('wsdl:part', $m)->item(0);
    if ($part instanceof DOMElement) {
        $messages[$m->getAttribute('name')] = strip_ns($part->getAttribute('type'));
    }
}

/**
 * complexType name => ['fields' => [name => [type, optional]], 'array' => ?itemType]
 *
 * SOAP-ENC arrays declare their element type in a wsdl:arrayType attribute
 * rather than as child elements, so they are recorded as arrays of that type.
 */
$types = [];
foreach ($xp->query('//xsd:complexType[@name]') as $ct) {
    $name = $ct->getAttribute('name');

    $arrayType = null;
    foreach ($xp->query('.//xsd:attribute', $ct) as $attr) {
        $decl = $attr->getAttributeNS('http://schemas.xmlsoap.org/wsdl/', 'arrayType');
        if ($decl !== '') {
            $arrayType = strip_ns(rtrim($decl, '[]'));
        }
    }

    $fields = [];
    foreach ($xp->query('.//xsd:element[@name]', $ct) as $el) {
        $fields[$el->getAttribute('name')] = [
            'type' => strip_ns($el->getAttribute('type')),
            'optional' => $el->getAttribute('minOccurs') === '0',
        ];
    }

    $types[$name] = ['fields' => $fields, 'array' => $arrayType];
}

/** Operations, resolved through portType -> message -> part type. */
$operations = [];
foreach ($xp->query('//wsdl:portType/wsdl:operation') as $op) {
    $name = $op->getAttribute('name');
    if (in_array($name, DEPRECATED, true)) {
        continue;
    }

    $in = $xp->query('wsdl:input', $op)->item(0);
    $outNode = $xp->query('wsdl:output', $op)->item(0);
    $docNode = $xp->query('wsdl:documentation', $op)->item(0);

    if (! $in instanceof DOMElement || ! $outNode instanceof DOMElement) {
        continue;
    }

    $operations[$name] = [
        'request' => $messages[strip_ns($in->getAttribute('message'))] ?? null,
        'response' => $messages[strip_ns($outNode->getAttribute('message'))] ?? null,
        'doc' => $docNode ? trim(preg_replace('/\s+/', ' ', $docNode->textContent)) : '',
    ];
}

printf(
    "Parsed %d operations, %d types (%d deprecated operations skipped)\n",
    count($operations),
    count($types),
    count(DEPRECATED)
);

// ---------------------------------------------------------------------------
// Plan
// ---------------------------------------------------------------------------

/** Which group each operation belongs to, and the prefix stripped from it. */
function group_of(string $op): array
{
    foreach ([
        ['ssl', 'SSL_'],
        ['hosting', 'hosting'],
        ['subscriptions', 'subscription'],
    ] as [$group, $prefix]) {
        if (str_starts_with($op, $prefix)) {
            return [$group, lcfirst(substr($op, strlen($prefix)))];
        }
    }

    foreach ([
        'dnssec' => ['DNSSEC', 'Dnssec', 'dnssec'],
        'dns' => ['DNS'],
        'forwarding' => ['MailForward', 'EmailToSMS', 'URLForward', 'SimpleURLForward'],
        'categories' => ['Category', 'Categories'],
        'registryHosts' => ['Host'],
        'sms' => ['SMS', 'Sms'],
    ] as $group => $needles) {
        foreach ($needles as $needle) {
            if (str_contains($op, $needle)) {
                return [$group, $op];
            }
        }
    }

    return ['domains', $op];
}

$groups = [];
foreach ($operations as $name => $op) {
    [$group, $method] = group_of($name);
    $groups[$group][$name] = $op + ['method' => $method];
}
ksort($groups);

foreach ($groups as $g => $ops) {
    printf("  %-14s %d operations\n", $g, count($ops));
}

// ---------------------------------------------------------------------------
// Emit
// ---------------------------------------------------------------------------

foreach (['Api', 'Request', 'Response'] as $dir) {
    if (! is_dir("{$out}/{$dir}")) {
        mkdir("{$out}/{$dir}", 0755, true);
    }
    array_map('unlink', glob("{$out}/{$dir}/*.php") ?: []);
}

/** Response and nested types reachable from any operation, emitted once each. */
$emitted = [];
$queue = [];
$envelopes = [];
foreach ($operations as $op) {
    if ($op['response'] !== null) {
        $queue[] = $op['response'];
        $envelopes[$op['response']] = true;
    }
}

while ($queue !== []) {
    $typeName = array_shift($queue);
    if (isset($emitted[$typeName]) || ! isset($types[$typeName])) {
        continue;
    }
    $emitted[$typeName] = true;

    $type = $types[$typeName];

    // A SOAP-ENC array is not a class of its own; it is a typed list. Queue the
    // element type and emit nothing for the wrapper.
    if ($type['array'] !== null) {
        $queue[] = $type['array'];
        continue;
    }

    foreach ($type['fields'] as $field) {
        if (isset($types[$field['type']])) {
            $queue[] = $field['type'];
        }
    }

    // getSubscriptionForClientResponse is both an operation's response and the
    // entry type of getSubscriptionsForClient's list. It is treated as an
    // envelope in both places; its own state is in subscriptionStatus.
    write_response_class($out, $typeName, $type, $types, isset($envelopes[$typeName]));
}

// A handful of request fields are arrays of structured entries rather than of
// scalars -- bulkRawDomainInfo takes {domain, authInfo} pairs, subscriptionOrder
// takes {productId, quantity}. Those entry types get a small request DTO each,
// so the caller builds them by name instead of by array shape.
$requestTypes = [];
foreach ($operations as $op) {
    foreach (($types[$op['request']]['fields'] ?? []) as $field) {
        $type = $types[$field['type']] ?? null;
        $item = $type['array'] ?? null;
        if ($item !== null && isset($types[$item]) && $types[$item]['fields'] !== []) {
            $requestTypes[$item] = true;
        }
    }
}

foreach (array_keys($requestTypes) as $typeName) {
    write_request_class($out, $typeName, $types[$typeName], $types);
}

foreach ($groups as $group => $ops) {
    write_api_class($out, $group, $ops, $types);
}

printf("Generated %d response classes and %d api classes\n", count(array_filter($emitted, fn ($v) => $v)), count($groups));

// Emitting canonically-formatted PHP from string templates is a losing game --
// brace placement for multi-line signatures alone is more rules than it is
// worth encoding here. Pint owns the house style, so it gets the last word and
// `pint --test` in CI then passes on freshly generated output.
$pint = $root . '/vendor/bin/pint';
if (is_executable($pint)) {
    exec(escapeshellarg($pint) . ' ' . escapeshellarg($out) . ' --quiet 2>&1', $ignored, $status);
    echo $status === 0 ? "Formatted with pint\n" : "pint exited {$status}\n";
} else {
    echo "pint not installed; run `composer install` and re-run to format\n";
}

// ---------------------------------------------------------------------------
// Helpers
// ---------------------------------------------------------------------------

function strip_ns(string $qname): string
{
    $pos = strpos($qname, ':');

    return $pos === false ? $qname : substr($qname, $pos + 1);
}

function class_name(string $typeName): string
{
    // SSL_getCertStatusResponse => SslGetCertStatusResponse
    $name = preg_replace('/^SSL_/', 'Ssl', $typeName);

    return ucfirst($name);
}

/**
 * Maps an XSD type to a PHP type.
 *
 * xsd:decimal becomes string rather than float: these are prices, and the wire
 * value is the most faithful thing to hand back. A caller wanting arithmetic
 * can use bcmath on it, which a float would already have made impossible.
 *
 * xsd:dateTime also becomes string. The WSDL is inconsistent about which date
 * fields it types -- domain_expiry is xsd:string while createdDate is
 * xsd:dateTime -- so parsing some and not others would be a coin toss dressed
 * up as an API. Generated code mirrors the wire; meaning is added by hand.
 */
function php_type(string $xsdType, array $types): array
{
    if (isset($types[$xsdType])) {
        if ($types[$xsdType]['array'] !== null) {
            $item = $types[$xsdType]['array'];

            // Two response types are arrays of arrays -- listClients returns
            // clientListArray of clientListTypeArray of the actual record.
            // Recursing keeps the doc type honest about that extra level.
            if (isset($types[$item])) {
                $inner = $types[$item]['array'] !== null
                    ? php_type($item, $types)[1]
                    : class_name($item);
            } else {
                $inner = php_type($item, $types)[0];
            }

            return ['array', "list<{$inner}>"];
        }

        return [class_name($xsdType), null];
    }

    return match ($xsdType) {
        'int', 'integer' => ['int', null],
        'boolean' => ['bool', null],
        'decimal', 'float', 'double' => ['string', null],
        default => ['string', null],
    };
}

function write_response_class(string $out, string $typeName, array $type, array $types, bool $envelope): void
{
    $class = class_name($typeName);
    $ns = NS . '\\Generated\\Response';

    $props = [];
    $hydrate = [];

    foreach ($type['fields'] as $name => $field) {
        if ($envelope && in_array($name, ENVELOPE_FIELDS, true)) {
            continue;
        }

        [$php, $docType] = php_type($field['type'], $types);
        $prop = prop_name($name);

        // Every response field is nullable regardless of what the WSDL claims.
        // The API omits fields routinely -- domainInfo alone varies its shape by
        // TLD -- and a missing field must not be a fatal error in a client whose
        // job is to report what came back.
        $doc = $docType !== null ? "        /** @var {$docType}|null */\n" : '';
        $props[] = $doc . "        public readonly ?{$php} \${$prop},";

        $hydrate[] = hydrate_expr($name, $prop, $field['type'], $types);
    }

    if ($props === []) {
        $props[] = '        // This response carries only the status envelope.';
    }

    $propsSrc = implode("\n", $props);
    $hydrateSrc = implode("\n", $hydrate);

    $src = <<<PHP
    <?php

    declare(strict_types=1);

    namespace {$ns};

    use Hampel\\SynergyWholesale\\HydratesFromWire;
    use Hampel\\SynergyWholesale\\Wire;

    /**
     * Generated from the Synergy Wholesale WSDL type "{$typeName}".
     *
     * Do not edit: run `composer generate` instead.
     */
    final class {$class} implements HydratesFromWire
    {
        public function __construct(
    {$propsSrc}
        ) {
        }

        public static function fromWire(object \$raw): static
        {
            return new self(
    {$hydrateSrc}
            );
        }
    }

    PHP;

    file_put_contents("{$out}/Response/{$class}.php", $src);
}

function hydrate_expr(string $wireName, string $prop, string $xsdType, array $types): string
{
    $key = var_export($wireName, true);

    if (isset($types[$xsdType])) {
        if ($types[$xsdType]['array'] !== null) {
            $item = $types[$xsdType]['array'];
            if (isset($types[$item])) {
                // An array whose entries are themselves arrays needs the extra
                // level unwrapped, not flattened away.
                if ($types[$item]['array'] !== null) {
                    $entryClass = class_name($types[$item]['array']);

                    return "            {$prop}: Wire::objectLists(\$raw, {$key}, {$entryClass}::class),";
                }

                $itemClass = class_name($item);

                return "            {$prop}: Wire::objects(\$raw, {$key}, {$itemClass}::class),";
            }

            [$php] = php_type($item, $types);

            return "            {$prop}: Wire::" . wire_method($php, true) . "(\$raw, {$key}),";
        }

        $class = class_name($xsdType);

        return "            {$prop}: Wire::object(\$raw, {$key}, {$class}::class),";
    }

    [$php] = php_type($xsdType, $types);

    return "            {$prop}: Wire::" . wire_method($php, false) . "(\$raw, {$key}),";
}

/**
 * Emits a request entry DTO: the caller-facing half of a structured array
 * parameter. Only the fields need naming -- validation belongs to the API.
 */
function write_request_class(string $out, string $typeName, array $type, array $types): void
{
    $class = class_name($typeName);
    $ns = NS . '\\Generated\\Request';

    $props = [];
    $wire = [];

    foreach ($type['fields'] as $name => $field) {
        [$php] = php_type($field['type'], $types);
        $hint = $field['optional'] ? "?{$php}" : $php;
        $default = $field['optional'] ? ' = null' : '';
        $props[] = "        public readonly {$hint} \${$name}{$default},";
        $wire[] = "            " . var_export($name, true) . " => \$this->{$name},";
    }

    $propsSrc = implode("\n", $props);
    $wireSrc = implode("\n", $wire);

    // Only wrap in array_filter when a field can actually be null, or the
    // comparison is statically always-true and static analysis says so.
    $hasOptional = false;
    foreach ($type['fields'] as $field) {
        $hasOptional = $hasOptional || $field['optional'];
    }
    $filterOpen = $hasOptional ? 'array_filter(' : '';
    $filterClose = $hasOptional ? ', static fn (mixed \$v): bool => \$v !== null)' : '';

    $src = <<<PHP
    <?php

    declare(strict_types=1);

    namespace {$ns};

    /**
     * Generated from the Synergy Wholesale WSDL type "{$typeName}".
     *
     * Do not edit: run `composer generate` instead.
     */
    final class {$class}
    {
        public function __construct(
    {$propsSrc}
        ) {
        }

        /**
         * @return array<string, mixed>
         */
        public function toWire(): array
        {
            return {$filterOpen}[
    {$wireSrc}
            ]{$filterClose};
        }
    }

    PHP;

    file_put_contents("{$out}/Request/{$class}.php", $src);
}

/**
 * One Wire method per target type, so each generated constructor argument
 * arrives as the type it was declared with rather than a union of everything
 * a general-purpose reader could have returned.
 */
function wire_method(string $php, bool $list): string
{
    return match ($php) {
        'int' => $list ? 'ints' : 'int',
        'bool' => $list ? 'bools' : 'bool',
        default => $list ? 'strings' : 'string',
    };
}

function write_api_class(string $out, string $group, array $ops, array $types): void
{
    $class = ucfirst($group) . 'Api';
    $ns = NS . '\\Generated\\Api';
    $methods = [];
    $uses = [];

    foreach ($ops as $opName => $op) {
        $request = $types[$op['request']] ?? ['fields' => []];
        $responseClass = class_name($op['response'] ?? '');
        $uses[NS . '\\Generated\\Response\\' . $responseClass] = true;

        $overrides = REQUIRED_OVERRIDES[$op['request']] ?? [];

        // Collapse contact blocks into Contact objects.
        //
        // Most carry a role prefix (registrant_firstname), but transferDomain
        // takes a single unprefixed set -- firstname, lastname, address and the
        // rest at the top level. The empty role covers that case, and turns
        // transferDomain's 24 parameters into 14.
        $roles = [];
        foreach (['', ...CONTACT_ROLES] as $role) {
            $prefix = $role === '' ? '' : "{$role}_";
            $present = 0;
            foreach (CONTACT_FIELDS as $f) {
                if (isset($request['fields']["{$prefix}{$f}"])) {
                    $present++;
                }
            }
            if ($present === count(CONTACT_FIELDS)) {
                $roles[] = $role;
            }
        }

        $required = [];
        $optional = [];
        $body = [];

        foreach ($request['fields'] as $name => $field) {
            if (in_array($name, AUTH_FIELDS, true)) {
                continue;
            }

            $folded = false;
            foreach ($roles as $r) {
                $folded = $r === ''
                    ? in_array($name, CONTACT_FIELDS, true)
                    : str_starts_with($name, "{$r}_");
                if ($folded) {
                    break;
                }
            }
            if ($folded) {
                continue; // folded into the Contact parameter below
            }

            [$php, $docType] = php_type($field['type'], $types);
            $prop = prop_name($name);
            // REQUIRED_OVERRIDES entries say whether the field IS required, so
            // they invert into the optional flag used from here on.
            $isOptional = isset($overrides[$name]) ? ! $overrides[$name] : $field['optional'];

            // An array of structured entries takes request DTOs, which the
            // call site flattens with toWire(). Anything else is scalars.
            $entryClass = null;
            $item = $types[$field['type']]['array'] ?? null;
            if ($item !== null && ($types[$item]['fields'] ?? []) !== []) {
                $entryClass = class_name($item);
                $docType = "list<{$entryClass}>";
                $uses[NS . '\\Generated\\Request\\' . $entryClass] = true;
            }

            $hint = $php === 'array' ? 'array' : $php;
            $entry = ['name' => $name, 'prop' => $prop, 'doc' => $docType, 'optional' => $isOptional, 'entryClass' => $entryClass];
            if ($isOptional) {
                $optional[] = $entry + ['sig' => "        ?{$hint} \${$prop} = null,"];
            } else {
                $required[] = $entry + ['sig' => "        {$hint} \${$prop},"];
            }
        }

        foreach ($roles as $role) {
            // The registrant, and a lone unprefixed set, are mandatory. The
            // other three roles fall back to the registrant when omitted, so
            // they must be omissible rather than explicitly null.
            $isOptional = $role !== 'registrant' && $role !== '';
            $prop = $role === '' ? 'contact' : $role;
            $hint = $isOptional ? '?Contact' : 'Contact';
            $default = $isOptional ? ' = null' : '';
            $entry = ['sig' => "        {$hint} \${$prop}{$default},", 'name' => $role, 'prop' => $prop, 'doc' => null, 'contact' => true];
            if ($isOptional) {
                $optional[] = $entry;
            } else {
                $required[] = $entry;
            }
        }

        $params = array_merge($required, $optional);

        foreach ($params as $p) {
            $key = var_export($p['name'], true);
            if (($p['contact'] ?? false) === true) {
                $body[] = "            ...Contact::wire('{$p['name']}', \${$p['prop']}),";
            } elseif (($p['entryClass'] ?? null) !== null) {
                $map = "array_map(static fn ({$p['entryClass']} \$e): array => \$e->toWire(), \${$p['prop']})";
                $body[] = ($p['optional'] ?? false)
                    ? "            {$key} => \${$p['prop']} === null ? null : {$map},"
                    : "            {$key} => {$map},";
            } else {
                $body[] = "            {$key} => \${$p['prop']},";
            }
        }

        $sig = $params === [] ? '' : "\n" . implode("\n", array_column($params, 'sig')) . "\n    ";
        $bodySrc = $body === [] ? '' : "\n" . implode("\n", $body) . "\n        ";
        $doc = $op['doc'] !== '' ? "     * {$op['doc']}\n     *\n" : '';

        if ($roles !== []) {
            $uses[NS . '\\Value\\Contact'] = true;
        }

        // PHPStan runs at level 10, where a bare `array` is an error. The
        // element type comes from the WSDL's SOAP-ENC arrayType declaration.
        foreach ($params as $p) {
            if (($p['doc'] ?? null) !== null) {
                // The nullable half of the docblock must match the signature:
                // a required array parameter is not nullable.
                $nullable = ($p['optional'] ?? false) ? '|null' : '';
                $doc .= "     * @param {$p['doc']}{$nullable} \${$p['prop']}\n";
            }
        }
        if (str_contains($doc, '@param')) {
            $doc .= "     *\n";
        }

        $methods[] = <<<PHP
            /**
        {$doc}     * SOAP operation: {$opName}
             */
            public function {$op['method']}({$sig}): {$responseClass}
            {
                return {$responseClass}::fromWire(\$this->client->call('{$opName}', [{$bodySrc}]));
            }
        PHP;
    }

    ksort($uses);
    $useSrc = '';
    foreach (array_keys($uses) as $fqcn) {
        $useSrc .= "use {$fqcn};\n";
    }

    $methodsSrc = implode("\n\n", $methods);

    $src = <<<PHP
    <?php

    declare(strict_types=1);

    namespace {$ns};

    use Hampel\\SynergyWholesale\\Client;
    {$useSrc}
    /**
     * Generated from the Synergy Wholesale WSDL.
     *
     * Do not edit: run `composer generate` instead.
     */
    final class {$class}
    {
        public function __construct(private readonly Client \$client)
        {
        }

    {$methodsSrc}
    }

    PHP;

    file_put_contents("{$out}/Api/{$class}.php", $src);
}

/**
 * Property names are the wire field names, verbatim.
 *
 * Normalising domain_expiry to domainExpiry looks tidier and is wrong. The
 * WSDL declares BOTH au_valid_eligibility and auValidEligibility in
 * domainInfoResponse, and both au_eligibility_last_check and
 * auEligibilityLastCheck -- snake and camel variants of the same field, live
 * on the wire together. Any snake-to-camel rule collapses those pairs into one
 * property and silently drops a field.
 *
 * Keeping the wire name also means the published PDF doubles as the reference:
 * a field documented as domain_expiry is read as ->domain_expiry, with no
 * translation step for the caller to get wrong.
 */
function prop_name(string $wireName): string
{
    return $wireName;
}
