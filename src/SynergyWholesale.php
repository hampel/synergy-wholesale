<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale;

use Hampel\SynergyWholesale\Generated\Api\CategoriesApi;
use Hampel\SynergyWholesale\Generated\Api\DnsApi;
use Hampel\SynergyWholesale\Generated\Api\DnssecApi;
use Hampel\SynergyWholesale\Generated\Api\DomainsApi;
use Hampel\SynergyWholesale\Generated\Api\ForwardingApi;
use Hampel\SynergyWholesale\Generated\Api\HostingApi;
use Hampel\SynergyWholesale\Generated\Api\RegistryHostsApi;
use Hampel\SynergyWholesale\Generated\Api\SmsApi;
use Hampel\SynergyWholesale\Generated\Api\SslApi;
use Hampel\SynergyWholesale\Generated\Api\SubscriptionsApi;
use Hampel\SynergyWholesale\Transport\SoapTransport;
use Hampel\SynergyWholesale\Transport\Transport;
use Psr\Log\LoggerInterface;

/**
 * Entry point for the Synergy Wholesale API.
 *
 * The 138 supported operations are grouped rather than flattened onto one
 * class. Within a group the method name is the API operation name with the
 * group's own prefix removed, so the published documentation reads directly as
 * the reference: "Command: checkDomain" is $sw->domains()->checkDomain(), and
 * "Command: SSL_getCertStatus" is $sw->ssl()->getCertStatus().
 */
final class SynergyWholesale
{
    public function __construct(private readonly Client $client)
    {
    }

    /**
     * Builds a client against the live API.
     *
     * Note that Synergy Wholesale authorises by IP allowlist as well as by
     * key: a correct reseller ID and API key from an unlisted address fails
     * with ERR_RESELLER_NOT_AUTHORISED.
     */
    public static function make(
        string $resellerId,
        string $apiKey,
        ?LoggerInterface $logger = null,
    ): self {
        return self::with(SoapTransport::make(), $resellerId, $apiKey, $logger);
    }

    /**
     * Builds a client over a supplied transport -- a fixture in tests, or a
     * decorator adding caching, retries or rate limiting in production.
     */
    public static function with(
        Transport $transport,
        string $resellerId,
        string $apiKey,
        ?LoggerInterface $logger = null,
    ): self {
        return new self(new Client($transport, $resellerId, $apiKey, $logger));
    }

    public function categories(): CategoriesApi
    {
        return new CategoriesApi($this->client);
    }

    public function dns(): DnsApi
    {
        return new DnsApi($this->client);
    }

    public function dnssec(): DnssecApi
    {
        return new DnssecApi($this->client);
    }

    public function domains(): DomainsApi
    {
        return new DomainsApi($this->client);
    }

    public function forwarding(): ForwardingApi
    {
        return new ForwardingApi($this->client);
    }

    public function hosting(): HostingApi
    {
        return new HostingApi($this->client);
    }

    public function registryHosts(): RegistryHostsApi
    {
        return new RegistryHostsApi($this->client);
    }

    public function sms(): SmsApi
    {
        return new SmsApi($this->client);
    }

    public function ssl(): SslApi
    {
        return new SslApi($this->client);
    }

    public function subscriptions(): SubscriptionsApi
    {
        return new SubscriptionsApi($this->client);
    }
}
