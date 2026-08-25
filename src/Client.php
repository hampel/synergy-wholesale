<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale;

use Hampel\SynergyWholesale\Exception\ApiError;
use Hampel\SynergyWholesale\Transport\Transport;
use Hampel\SynergyWholesale\Transport\TransportException;
use Psr\Log\LoggerInterface;

/**
 * Dispatches one API call: injects credentials, applies the envelope rule, and
 * logs both directions with the secrets removed.
 *
 * The generated API classes hold one of these and do nothing else themselves,
 * so all the behaviour that is worth testing lives here rather than being
 * copied 138 times.
 */
final class Client
{
    /**
     * Request fields that must never reach a log.
     *
     * authInfo is the EPP/auth code -- possession of it is sufficient to
     * transfer a domain away, so it belongs on this list as firmly as the API
     * key does.
     */
    private const REDACTED = ['resellerID', 'apiKey', 'authInfo', 'domainPassword', 'password'];

    public function __construct(
        private readonly Transport $transport,
        private readonly string $resellerId,
        private readonly string $apiKey,
        private readonly ?LoggerInterface $logger = null,
    ) {
    }

    /**
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

        $this->log('info', "Calling {$operation}");
        $this->log('debug', "{$operation} request", $this->redact($request));

        $raw = $this->transport->call($operation, [
            'resellerID' => $this->resellerId,
            'apiKey' => $this->apiKey,
        ] + $request);

        $this->log('debug', "{$operation} response", $this->redact($this->toArray($raw)));

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

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function redact(array $data): array
    {
        foreach (array_keys($data) as $key) {
            if (in_array($key, self::REDACTED, true)) {
                $data[$key] = '*****';
            }
        }

        return $data;
    }

    /**
     * @return array<string, mixed>
     */
    private function toArray(object $raw): array
    {
        /** @var array<string, mixed> */
        return json_decode(json_encode($raw) ?: '{}', true) ?: [];
    }

    /**
     * @param  array<string, mixed>  $context
     */
    private function log(string $level, string $message, array $context = []): void
    {
        $this->logger?->log($level, $message, $context);
    }
}
