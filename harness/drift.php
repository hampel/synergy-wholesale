<?php

/**
 * Exercise: name the response fields the API sends that the generated classes drop.
 *
 * Reaches the live Synergy Wholesale API. Read-only.
 *
 * THE QUESTION THIS EXISTS TO SETTLE, and it is the one the test suite structurally
 * cannot reach.
 *
 * src/Generated is produced from resources/wsdl.xml. Two CI jobs guard that: one
 * regenerates and fails if the committed output has drifted from the pinned WSDL, and one
 * warns when the published WSDL differs from the pinned copy. Between them they cover
 * every way the WSDL can move.
 *
 * Neither covers the case where Synergy Wholesale returns a field the WSDL never declared.
 * The WSDL is unchanged, so both jobs are green; the field is real and arriving; and
 * Wire::string() and friends are total by design, so the field is dropped in silence -
 * no exception, no log line, no failing test. Nothing anywhere goes red.
 *
 * This is the silent-success shape: a call that returns 200, hydrates cleanly, and has
 * quietly lost data. It cannot be asserted without already knowing which field is missing,
 * which is the thing being discovered. A person reading a list of field names can see it
 * at once, which is why this is an exercise and not a test.
 *
 * It reports the reverse direction too - fields the class declares that never arrive.
 * That one is harmless at runtime, since a missing field is null, but the two reasons a
 * field can be absent mean opposite things and the exercise has to keep them apart:
 *
 *   conditional     the API sends it only in some responses. checkDomain is documented
 *                   this way - an unavailable domain returns neither costPrice nor
 *                   premium, because a name you cannot buy has no price. That is why
 *                   checkDomain is probed twice below, once each way: the pair is what
 *                   makes the distinction visible rather than assumed.
 *   over-promised   the WSDL declares it and the API never sends it at all. This is the
 *                   one worth knowing before exposing a field in a consumer.
 *
 * Two exclusions, both deliberate rather than oversights:
 *
 *   status, errorMessage   the envelope. Client consumes both and the generator strips
 *                          them from every response class, so they are always "on the
 *                          wire and not declared" and would swamp the real findings.
 *   nested records         only the top level of each response is compared. A field
 *                          inside domainList[] that the WSDL missed would not show up
 *                          here. Worth doing, not done - say so rather than reading a
 *                          clean run as more than it is.
 *
 * Needs SW_RESELLER_ID and SW_API_KEY. Reads the account's domains, so it needs one.
 *
 * @var Hampel\Rig\Io $io
 */

require_once __DIR__ . '/lib/bootstrap.php';

use Hampel\SynergyWholesale\Exception\SynergyWholesaleException;

$io->title('synergy-wholesale · drift');

harness_mode($io);

$recorder = null;
$sw = harness_client($io, $recorder);

/** The envelope, handled by Client and deliberately absent from every response class. */
const ENVELOPE = ['status', 'errorMessage'];

$nonce = bin2hex(random_bytes(4));

/**
 * Keyed by label, holding [operation, call]. The two are not the same thing here:
 * RecordingTransport keys on the operation name, so two probes of one operation would
 * collide if the label were used to read the recorder back.
 *
 * @var array<string, array{string, callable(): object}>
 */
$probes = [
    'balanceQuery' => ['balanceQuery', fn () => $sw->domains()->balanceQuery()],
    'listAvailableDomainExtensions' => ['listAvailableDomainExtensions', fn () => $sw->domains()->listAvailableDomainExtensions()],
    'getDomainPricing' => ['getDomainPricing', fn () => $sw->domains()->getDomainPricing()],
    'getSSLPricing' => ['getSSLPricing', fn () => $sw->domains()->getSSLPricing()],

    // The pair. example.com is permanently registered, so it answers UNAVAILABLE and the
    // documentation says the pricing block is withheld. The random name is almost
    // certainly free, so it answers AVAILABLE and should carry it. Anything still absent
    // from the second row is over-promised rather than conditional.
    'checkDomain (unavailable)' => ['checkDomain', fn () => $sw->domains()->checkDomain(domainName: 'example.com')],
    'checkDomain (available)' => ['checkDomain', fn () => $sw->domains()->checkDomain(domainName: "zzz-no-such-domain-{$nonce}.com")],

    'listDomains' => ['listDomains', fn () => $sw->domains()->listDomains(limit: 1)],
];

$undeclared = 0;
$absent = 0;

foreach ($probes as $label => [$operation, $probe]) {
    try {
        $hydrated = $probe();
    } catch (SynergyWholesaleException $e) {
        $io->error(sprintf('✗ %-30s %s', $label, $e->getMessage()));

        continue;
    }

    $raw = $recorder->responses[$operation] ?? null;

    if (! is_object($raw)) {
        $io->warn(sprintf('  %-30s nothing recorded', $label));

        continue;
    }

    $onWire = array_keys(get_object_vars($raw));
    $declared = array_keys(get_object_vars($hydrated));

    $missing = array_diff($onWire, $declared, ENVELOPE);
    $unused = array_diff($declared, $onWire);

    $undeclared += count($missing);
    $absent += count($unused);

    if ($missing === []) {
        $io->success(sprintf('✓ %-30s %d field(s), all declared', $label, count($onWire)));
    } else {
        $io->error(sprintf('✗ %-30s %d field(s) ON THE WIRE AND DROPPED:', $label, count($missing)));
        $io->line('      ' . implode(', ', $missing));
    }

    if ($unused !== []) {
        $io->line(sprintf('      declared but not sent: %s', implode(', ', $unused)));
    }
}

$io->line();

if ($undeclared > 0) {
    $io->error(sprintf('%d field(s) are being dropped.', $undeclared));
    $io->line();
    $io->info('Refresh the WSDL and regenerate first - the field may simply be newer than');
    $io->info('the pinned copy:');
    $io->line();
    $io->line("    curl -o resources/wsdl.xml 'https://api.synergywholesale.com/?wsdl'");
    $io->line('    composer generate');
    $io->line();
    $io->info('If it is still dropped after that, the WSDL does not declare it and Synergy');
    $io->info('Wholesale is sending it anyway. That is a report to them, not a code change');
    $io->info('here - the generator has no source for a field the WSDL does not mention.');
} else {
    $io->success('No dropped fields at the top level of any response probed.');
}

if ($absent > 0) {
    $io->line();
    $io->info(sprintf('%d declared field(s) did not arrive. Harmless at runtime - a missing', $absent));
    $io->info('field is null - but read the two checkDomain rows against each other before');
    $io->info('concluding anything, because absence has two causes that mean opposite things:');
    $io->line();
    $io->info('  conditional     absent from the unavailable row and present in the available');
    $io->info('                  one. Documented behaviour: a name you cannot buy has no');
    $io->info('                  price, so costPrice and premium are withheld.');
    $io->info('  over-promised   absent from BOTH rows. The WSDL declares it and the API');
    $io->info('                  never sends it. That is the one not to build a consumer on.');
    $io->line();
    $io->info('Note premium is also subject to the "Show premium domains as available"');
    $io->info('setting on the reseller account: with it off, a premium name answers');
    $io->info('UNAVAILABLE, and an unavailable answer carries no premium field to read.');
}

$io->line();
$io->info('Top level only. A field missing from a nested record - inside domainList[], or');
$io->info('inside pricing[] - would not appear above.');
