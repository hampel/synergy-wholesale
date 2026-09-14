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
     * Fields that must never reach a log, in either direction and at any depth.
     *
     * The EPP code travels under four names and the .au association codes under
     * three -- possession of any of them is sufficient to transfer a domain away,
     * so they belong here as firmly as the API key does. privKey is the private
     * key SSL_generateCSR hands back.
     *
     * Lowercase, and compared that way: the WSDL spells authInfo as authinfo in
     * rawDomainContacts.
     */
    private const REDACTED = [
        'resellerid',
        'apikey',
        'authinfo',
        'domainpassword',
        'associationauthinfo',
        'auassociationauthinfo',
        'aueligibilityassociationauthinfo',
        'password',
        'newpassword',
        'privkey',
        'privatekey',
    ];

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
     * Recursive because the secrets are not all at the top: listDomains and
     * bulkDomainInfo carry domainPassword on every entry of domainList, so a
     * single call at debug would otherwise log the transfer code for every
     * domain in the account.
     *
     * @param  array<mixed>  $data
     * @return array<mixed>
     */
    private function redact(array $data): array
    {
        foreach ($data as $key => $value) {
            if (is_string($key) && in_array(strtolower($key), self::REDACTED, true)) {
                $data[$key] = '*****';
            } elseif (is_array($value)) {
                $data[$key] = $this->redact($value);
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
     * @param  array<mixed>  $context
     */
    private function log(string $level, string $message, array $context = []): void
    {
        $this->logger?->log($level, $message, $context);
    }
}
