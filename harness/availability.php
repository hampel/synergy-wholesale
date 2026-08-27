<?php

/**
 * Exercise: availability checks, and the envelope statuses they really come back with.
 *
 * Reaches the live Synergy Wholesale API. Read-only - an availability check is free and
 * is not observable to the domain's owner.
 *
 * THE QUESTION THIS EXISTS TO SETTLE. v2's central behavioural bet is that success is any
 * status not prefixed ERR_. v1 whitelisted the success values per response class and threw
 * on statuses that meant success - CheckDomainResponse had to special-case AVAILABLE and
 * UNAVAILABLE to work at all. If the registry has since invented another one, v2 handles
 * it and v1 could not, and the only way to find out which statuses exist is to collect
 * them from real calls.
 *
 * That is why this reads from the recorder rather than the response object: Client
 * consumes the envelope status deliberately, so by the time CheckDomainResponse exists
 * the status is gone. The status is the answer here, so the exercise goes under the
 * package rather than through it - the pattern the rig-harness skill calls probing raw.
 *
 * The names are chosen so nothing here identifies anyone. example.com is reserved by IANA
 * for exactly this, and the unregistered names are random per run.
 *
 * Needs SW_RESELLER_ID and SW_API_KEY.
 *
 * @var Hampel\Rig\Io $io
 */

require_once __DIR__ . '/lib/bootstrap.php';

use Hampel\SynergyWholesale\Exception\SynergyWholesaleException;

$io->title('synergy-wholesale · availability');

harness_mode($io);

$recorder = null;
$sw = harness_client($io, $recorder);

$nonce = bin2hex(random_bytes(4));

$names = [
    'example.com' => 'registered - IANA reserves it, so this is always taken',
    'example.com.au' => 'registered - the .au equivalent',
    "zzz-no-such-domain-{$nonce}.com" => 'random, so almost certainly free',
    "zzz-no-such-domain-{$nonce}.com.au" => 'random, and .au has eligibility rules',
];

$statuses = [];

foreach ($names as $name => $why) {
    try {
        $check = $sw->domains()->checkDomain(domainName: $name);
    } catch (SynergyWholesaleException $e) {
        $io->error(sprintf('✗ %-38s %s', $name, $e->getMessage()));

        continue;
    }

    // The recorder holds the wire object verbatim -- nothing has typed it on the way
    // through, so this really is mixed. Narrow rather than cast: a status arriving as
    // something other than a string is a result worth seeing, not one to stringify away.
    $raw = $recorder->responses['checkDomain'] ?? null;
    $envelope = is_object($raw) ? $raw->status ?? null : null;

    $status = match (true) {
        is_string($envelope) => $envelope,
        $envelope === null => '(none)',
        default => '(non-string: ' . get_debug_type($envelope) . ')',
    };

    $statuses[$status] = ($statuses[$status] ?? 0) + 1;

    $io->line(sprintf(
        '  %-38s %-14s available=%s%s',
        $name,
        $status,
        $check->available === null ? 'null' : (string) $check->available,
        $check->premium === true ? '  [premium ' . $check->costPrice . ']' : '',
    ));
    $io->line(sprintf('  %-38s %s', '', $why));
}

$io->line();

// The bulk call takes up to 30 names and returns a row per name. Worth its own look
// because the rows answer in a different vocabulary from the single check above: there is
// no per-row status at all, and the name field is "domain", not "domainName". Availability
// arrives as a bool rather than as an AVAILABLE/UNAVAILABLE status string.
try {
    $bulk = $sw->domains()->bulkCheckDomain(domainList: array_keys($names));

    $io->success(sprintf('✓ bulkCheckDomain returned %d row(s)', count($bulk->domainList ?? [])));

    foreach ($bulk->domainList ?? [] as $row) {
        $io->line(sprintf(
            '  %-38s available=%s%s',
            $row->domain ?? '(no domain field)',
            match ($row->available) {
                true => 'true',
                false => 'false',
                null => 'null',
            },
            $row->premium === true ? '  [premium ' . $row->costPrice . ']' : '',
        ));
    }
} catch (SynergyWholesaleException $e) {
    $io->error('✗ bulkCheckDomain: ' . $e->getMessage());
}

$io->line();
$io->info('Envelope statuses seen this run, and how often:');

$counts = [];

foreach ($statuses as $status => $count) {
    $counts['  ' . $status] = $count;
}

$io->values($counts);

$io->line();
$io->info('Any status here that is not AVAILABLE or UNAVAILABLE is the interesting result:');
$io->info('it is one v1 would have thrown on. Anything prefixed ERR_ never reaches this');
$io->info('list, because Client turns those into ApiError before the response is built.');
