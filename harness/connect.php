<?php

/**
 * Exercise: the smallest real call there is - read the reseller account balance.
 *
 * Reaches the live Synergy Wholesale API. Read-only.
 *
 * Run this first when anything is wrong. It is the only exercise here with no moving
 * parts, so it separates the four things that fail together and look alike:
 *
 *   - the credentials are wrong
 *   - the credentials are right and this machine is not on the IP whitelist
 *   - the SOAP endpoint is unreachable
 *   - the envelope arrived and the package could not read it
 *
 * The second is the one worth naming. Synergy Wholesale authorises by IP address AS WELL
 * AS by key, so a correct key from an unlisted address fails - and it fails as
 * ERR_RESELLER_NOT_AUTHORISED, which reads like a bad key. This box is not a production
 * server, so unless its address has been added deliberately, that error here is expected
 * and means nothing is broken.
 *
 * Needs SW_RESELLER_ID and SW_API_KEY.
 *
 * @var Hampel\Rig\Io $io
 */

require_once __DIR__ . '/lib/bootstrap.php';

use Hampel\SynergyWholesale\Exception\ApiError;
use Hampel\SynergyWholesale\Transport\TransportException;

$io->title('synergy-wholesale · connect');

harness_mode($io);

$sw = harness_client($io);

try {
    $balance = $sw->domains()->balanceQuery();
} catch (ApiError $e) {
    $io->error('✗ ' . $e->status);
    $io->value('message', $e->getMessage());

    if ($e->isAuthFailure()) {
        $io->line();
        $io->info('Credentials, or this machine is not on the API IP whitelist. Both');
        $io->info('produce this status and the API does not distinguish them.');
    }

    exit(1);
} catch (TransportException $e) {
    $io->error('✗ the call did not complete');
    $io->value('message', $e->getMessage());

    exit(1);
}

$io->success('✓ authorised, and the envelope parsed');
$io->line();
$io->value('balance', $balance->balance);
$io->value('statusCode', $balance->statusCode);
$io->value('reason', $balance->reason);

$io->line();
$io->info('The envelope status is not among those - Client consumes it and the generator');
$io->info('strips it from every operation\'s response. statusCode and reason are separate fields');
$io->info('this operation declares in the WSDL, which is why both spellings are here.');
