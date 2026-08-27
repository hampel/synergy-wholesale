<?php

/**
 * Exercise: the account-independent catalogue reads - extensions, pricing, TLD options.
 *
 * Reaches the live Synergy Wholesale API. Read-only.
 *
 * These are account-independent: every reseller gets the same answer, so the output
 * carries nothing about the account it was run from and can be pasted into a bug report
 * without redacting anything. That is not true of any other exercise here.
 *
 * What it is for is the shape of the responses rather than their contents. The three
 * list operations return SOAP-ENC arrays of nested records, which is the part of the wire
 * format the fixtures in tests/ are least able to vouch for - a fixture is a shape
 * somebody typed out believing it was right. The field names printed under each count are
 * what to read: they are what the API sent, not what the WSDL promised.
 *
 * Needs SW_RESELLER_ID and SW_API_KEY. Takes a TLD as its first argument, default com.au.
 *
 * @var Hampel\Rig\Io $io
 */

require_once __DIR__ . '/lib/bootstrap.php';

use Hampel\SynergyWholesale\Exception\SynergyWholesaleException;

$io->title('synergy-wholesale · catalogue');

harness_mode($io);

$sw = harness_client($io);
$tld = $argv[1] ?? 'com.au';

$lists = [
    'listAvailableDomainExtensions' => fn () => $sw->domains()->listAvailableDomainExtensions()->extensions,
    'getDomainPricing' => fn () => $sw->domains()->getDomainPricing()->pricing,
    'getSSLPricing' => fn () => $sw->domains()->getSSLPricing()->pricing,
];

foreach ($lists as $operation => $read) {
    try {
        $rows = $read();
    } catch (SynergyWholesaleException $e) {
        $io->error(sprintf('✗ %-30s %s', $operation, $e->getMessage()));

        continue;
    }

    if ($rows === null) {
        $io->warn(sprintf('  %-30s null - the field was absent from the response', $operation));

        continue;
    }

    $io->success(sprintf('✓ %-30s %d row(s)', $operation, count($rows)));

    $first = reset($rows);

    if (is_object($first)) {
        $io->line('    fields: ' . implode(', ', array_keys(get_object_vars($first))));
    }
}

// Flat record rather than a list, and the only catalogue call that takes a parameter.
// Worth its own block because the answer varies by extension and the .au rules are the
// ones most likely to move.
try {
    $options = $sw->domains()->getDomainExtensionOptions(tld: $tld);
} catch (SynergyWholesaleException $e) {
    $io->error(sprintf('✗ %-30s %s', 'getDomainExtensionOptions', $e->getMessage()));

    exit(1);
}

$io->success(sprintf('✓ %-30s .%s', 'getDomainExtensionOptions', $tld));
$io->line();
$io->values([
    'minYears / maxYears' => $options->minYears . ' / ' . $options->maxYears,
    'canRenewWithin' => $options->canRenewWithin,
    'cannotRestoreAfter' => $options->cannotRestoreAfter,
    'idProtect capable' => $options->isIDProtectCapable,
    'DNSSEC available' => $options->DNSSECAvailable,
    'available contacts' => $options->availableContacts,
]);

$io->line();
$io->info('Nothing above is specific to this account, so it is safe to paste anywhere.');
