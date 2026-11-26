<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale;

use Hampel\SynergyWholesale\Exception\ApiError;
use Hampel\SynergyWholesale\Transport\Transport;
use Hampel\SynergyWholesale\Transport\TransportException;
use Psr\Log\LoggerInterface;

/**
 * Dispatches one API call: injects credentials, applies the envelope rule, and
 * logs that the call happened.
 *
 * The generated API classes hold one of these and do nothing else themselves,
 * so all the behaviour that is worth testing lives here rather than being
 * copied 138 times.
 */
final class Client
{
    /**
     * One constant message for every call, so a log store can group and count
     * them; what varies is in the context.
     */
    public const LOG_MESSAGE = 'Synergy Wholesale API call';

    public function __construct(
        private readonly Transport $transport,
        private readonly string $resellerId,
        private readonly string $apiKey,
        private readonly ?LoggerInterface $logger = null,
    ) {
    }

    /**
     * Logs one debug line per call -- the operation, the status it answered with
     * and how long it took -- and nothing from the request or the response. Those
     * carry EPP codes, private keys and registrant contact details, and a field the
     * API adds later would be logged without anyone deciding to.
     *
     * The status is null when the call could not be completed.
     *
     * @param  array<string, mixed>  $params
     *
     * @throws ApiError when the API answers with an ERR_ status
     * @throws TransportException when the call cannot be completed
     */
    public function call(string $operation, array $params): object
    {
        // Null means "caller did not supply this". Sending it explicitly makes
        // some operations reject the whole request, so absent stays absent.
        $request = array_filter($params, static fn (mixed $v): bool => $v !== null);

        $started = hrtime(true);
        $status = null;

        try {
            $raw = $this->transport->call($operation, [
                'resellerID' => $this->resellerId,
                'apiKey' => $this->apiKey,
            ] + $request);

            $status = is_string($raw->status ?? null) ? $raw->status : null;
        } finally {
            $this->logger?->log('debug', self::LOG_MESSAGE, [
                'operation' => $operation,
                'status' => $status,
                'duration_ms' => intdiv(hrtime(true) - $started, 1_000_000),
            ]);
        }

        $this->assertSuccess($operation, $raw);

        return $raw;
    }

    /**
     * Applies the envelope rule shared by all 143 operations.
     *
     * Success is anything that is not prefixed ERR_. That covers plain OK, the
     * OK_NO_RENEWAL and OK_ELIGIBILITY variants, and the operations that answer
     * with a domain-specific word instead -- checkDomain returns AVAILABLE or
     * UNAVAILABLE, both of which are successful calls reporting a fact.
     *
     * The v1 package inverted this, whitelisting the success values per
     * response class, which meant every new status value the registry invented
     * arrived as a thrown exception.
     */
    private function assertSuccess(string $operation, object $raw): void
    {
        $status = $raw->status ?? null;

        if (! is_string($status) || $status === '') {
            throw new TransportException(
                "No status in the response to [{$operation}]",
                $operation,
            );
        }

        if (! str_starts_with($status, 'ERR_')) {
            return;
        }

        $message = $raw->errorMessage ?? null;

        throw new ApiError(
            $status,
            is_string($message) && $message !== '' ? $message : $status,
            $operation,
            $raw,
        );
    }
}
