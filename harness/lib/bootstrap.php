<?php

/**
 * Not an exercise - see lib/agent.php for why files live down here.
 *
 * Credentials, and the transport stack every exercise runs over.
 */

require_once __DIR__ . '/ReadOnlyTransport.php';
require_once __DIR__ . '/RecordingTransport.php';

use Hampel\Rig\Io;
use Hampel\SynergyWholesale\SynergyWholesale;
use Hampel\SynergyWholesale\Transport\SoapTransport;

/**
 * Builds a client whose transport cannot reach a write operation.
 *
 * The recorder is optional and goes INSIDE the guard, so what it captures is what the
 * network actually returned rather than what the guard let through.
 *
 * Exits rather than returning on a missing credential. An exercise that carried on would
 * fail later, deeper, and with a message about SOAP rather than about the thing that is
 * actually wrong.
 */
function harness_client(Io $io, ?RecordingTransport &$recorder = null): SynergyWholesale
{
    $resellerId = getenv('SW_RESELLER_ID');
    $apiKey = getenv('SW_API_KEY');

    if ($resellerId === false || $resellerId === '' || $apiKey === false || $apiKey === '') {
        $io->error('SW_RESELLER_ID and SW_API_KEY are not both set.');
        $io->line();

        if (getenv('CLAUDECODE') !== false) {
            $io->info('This is an agent session, so rig did not read .env - that is the guard');
            $io->info('working, not a fault. Do not go looking for the key. Ask.');
        } else {
            $io->info('Copy .env.example to .env beside the package and fill it in.');
        }

        exit(1);
    }

    $transport = SoapTransport::make();

    if (func_num_args() > 1) {
        $transport = $recorder = new RecordingTransport($transport);
    }

    return SynergyWholesale::with(new ReadOnlyTransport($transport), $resellerId, $apiKey);
}

/**
 * Prints the mode before any work happens, never after.
 *
 * A run that did less than the reader assumes has to say so above the output, because by
 * the time they reach the bottom they have already read the results as a pass.
 */
function harness_mode(Io $io): void
{
    $io->info('mode: read-only - every call is checked against ReadOnlyTransport::ALLOWED');

    if (getenv('CLAUDECODE') !== false) {
        $io->info('agent session: .env was not read; credentials must come from the environment');
    }

    $io->line();
}
