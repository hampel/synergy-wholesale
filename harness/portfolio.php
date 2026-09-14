<?php

/**
 * Exercise: list the account's domains, then read one of them in full.
 *
 * Reaches the live Synergy Wholesale API. Read-only.
 *
 * THE OUTPUT IS ABOUT REAL CUSTOMERS, and that shapes the whole exercise. It prints
 * counts, shapes and field names by default and NOT the domain list, because this
 * repository is public and an example pasted out of a run is how a customer's domain ends
 * up in it. Pass --show to print names when you actually need them.
 *
 * For the same reason nothing here hardcodes a domain: the subject is whatever listDomains
 * returns first. A domain name written into a harness file is a customer's name committed
 * to a public repository, and it stays there after the domain moves on.
 *
 * What it is for beyond the shapes: domainInfo is the response that varies most by TLD -
 * a .au domain carries eleven auEligibility* fields a .com does not - and nameServers is
 * the field that exposes the SOAP-ENC single-element problem. An account with exactly one
 * nameserver on a domain returns a bare value where two return a list, and Wire::strings()
 * normalising that is a claim only a real account can check.
 *
 * And autoRenew, which the WSDL types two ways: xsd:int on the listDomains entry, xsd:string
 * on domainInfo. The published listDomains example shows 'off', which Wire::int() cannot
 * read - if that is what the wire sends, autoRenew is null on every list and bulk call and
 * nothing says so. The raw value is printed beside what each class made of it.
 *
 * Needs SW_RESELLER_ID and SW_API_KEY.
 *
 * @var Hampel\Rig\Io $io
 */

require_once __DIR__ . '/lib/bootstrap.php';

use Hampel\SynergyWholesale\Exception\SynergyWholesaleException;

$io->title('synergy-wholesale · portfolio');

harness_mode($io);

$show = in_array('--show', $argv, true);

if (! $show) {
    $io->info('names are hidden - pass --show to print them');
    $io->line();
}

$recorder = null;
$sw = harness_client($io, $recorder);

try {
    $domains = $sw->domains()->listDomains(limit: 25);
} catch (SynergyWholesaleException $e) {
    $io->error('✗ listDomains: ' . $e->getMessage());

    exit(1);
}

$list = $domains->domainList ?? [];

$io->success(sprintf('✓ listDomains returned %d row(s)', count($list)));
$io->value('page', $domains->page);
$io->value('limit', $domains->limit);

if ($list === []) {
    $io->line();
    $io->warn('No domains on this account, so there is nothing to read in full.');
    $io->info('The catalogue and availability exercises do not need any, and are the');
    $io->info('ones to run on an empty or test account.');

    exit(0);
}

$first = reset($list);
$io->line('    fields: ' . implode(', ', array_keys(get_object_vars($first))));

$subject = $first->domainName ?? null;

if (! is_string($subject) || $subject === '') {
    $io->error('✗ the first row carries no domainName, so there is nothing to follow up');

    exit(1);
}

$io->line();
$io->info('Reading the first domain in full' . ($show ? ": {$subject}" : ''));
$io->line();

try {
    $info = $sw->domains()->domainInfo(domainName: $subject);
} catch (SynergyWholesaleException $e) {
    $io->error('✗ domainInfo: ' . $e->getMessage());

    exit(1);
}

$io->success('✓ domainInfo');
$io->value('status', $info->domain_status);
$io->value('expiry', $info->domain_expiry);
$io->value('idProtect', $info->idProtect);

// The single-element list case. One nameserver on the wire is a bare value, not a list,
// and Wire::strings() is what makes both arrive here as an array. A count of 1 printed
// below means that path really ran against real data.
$io->value('nameServers', $show ? $info->nameServers : count($info->nameServers ?? []) . ' (hidden)');

// The recorder holds each response as it came off the wire, before Wire typed it. A
// listDomains page of one entry arrives as a bare object rather than a list - the same
// SOAP-ENC case as nameServers - so both shapes are read. $io renders a string quoted and
// an int bare, so the type needs no label of its own: 'off' and 1 read differently.
$onWire = static fn (mixed $record): mixed => is_object($record) && property_exists($record, 'autoRenew')
    ? $record->autoRenew
    : '(absent from the response)';

$rawList = $recorder->responses['listDomains']->domainList ?? null;

$io->line();
$io->info('autoRenew, as sent and as hydrated:');
$io->values([
    'listDomains wire' => $onWire(is_array($rawList) ? $rawList[0] ?? null : $rawList),
    'listDomains typed' => $first->autoRenew,
    'domainInfo wire' => $onWire($recorder->responses['domainInfo'] ?? null),
    'domainInfo typed' => $info->autoRenew,
]);

$auFields = array_filter(
    get_object_vars($info),
    static fn (mixed $value, string $name): bool => $value !== null && str_starts_with($name, 'au'),
    ARRAY_FILTER_USE_BOTH,
);

$io->line();
$io->info(sprintf('%d .au-specific field(s) populated: %s', count($auFields), implode(', ', array_keys($auFields)) ?: '-'));

try {
    $contacts = $sw->domains()->listContacts(domainName: $subject);
} catch (SynergyWholesaleException $e) {
    $io->line();
    $io->error('✗ listContacts: ' . $e->getMessage());

    exit(1);
}

$io->line();
$io->success('✓ listContacts');

foreach (['registrant', 'admin', 'tech', 'billing'] as $role) {
    $contact = $contacts->{$role};

    $io->line(sprintf(
        '  %-12s %s',
        $role,
        $contact === null
            ? '- not returned for this TLD'
            : ($show ? trim($contact->firstname . ' ' . $contact->lastname) . ' <' . $contact->email . '>' : 'present'),
    ));
}

$io->line();
$io->info('A role missing above is not a fault: .uk domains have no tech contact, and the');
$io->info('API omits the field rather than returning an empty one. Every Wire helper is');
$io->info('total for that reason - a missing field is null, never an error.');
