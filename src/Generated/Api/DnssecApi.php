<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Api;

use Hampel\SynergyWholesale\Client;
use Hampel\SynergyWholesale\Generated\Response\DNSSECAddDSResponse;
use Hampel\SynergyWholesale\Generated\Response\DNSSECListDSResponse;
use Hampel\SynergyWholesale\Generated\Response\DNSSECRemoveDSResponse;
use Hampel\SynergyWholesale\Generated\Response\DisableDnssecResponse;
use Hampel\SynergyWholesale\Generated\Response\EnableDnssecResponse;
use Hampel\SynergyWholesale\Generated\Response\GetDnssecRecordsResponse;

/**
 * Generated from the Synergy Wholesale WSDL.
 *
 * Do not edit: run `composer generate` instead.
 */
final class DnssecApi
{
    public function __construct(private readonly Client $client)
    {
    }

    /**
     * This function will enable DNSSEC on the DNS zone of the requested domain and replace any existing DS records on the domain
     *
     * SOAP operation: enableDnssec
     */
    public function enableDnssec(
        string $domainName,
    ): EnableDnssecResponse {
        return EnableDnssecResponse::fromWire($this->client->call('enableDnssec', [
            'domainName' => $domainName,
        ]));
    }

    /**
     * This function will disable DNSSEC on the DNS zone of the requested domain and remove any existing DS records on the domain
     *
     * SOAP operation: disableDnssec
     */
    public function disableDnssec(
        string $domainName,
    ): DisableDnssecResponse {
        return DisableDnssecResponse::fromWire($this->client->call('disableDnssec', [
            'domainName' => $domainName,
        ]));
    }

    /**
     * This function will return all DS records associated with the DNS zone of the requested domain
     *
     * SOAP operation: getDnssecRecords
     */
    public function getDnssecRecords(
        string $domainName,
    ): GetDnssecRecordsResponse {
        return GetDnssecRecordsResponse::fromWire($this->client->call('getDnssecRecords', [
            'domainName' => $domainName,
        ]));
    }

    /**
     * Add registry side DNSSEC DS data for a domain
     *
     * SOAP operation: DNSSECAddDS
     */
    public function DNSSECAddDS(
        string $domainName,
        int $keyTag,
        int $algorithm,
        int $digestType,
        string $digest,
    ): DNSSECAddDSResponse {
        return DNSSECAddDSResponse::fromWire($this->client->call('DNSSECAddDS', [
            'domainName' => $domainName,
            'keyTag' => $keyTag,
            'algorithm' => $algorithm,
            'digestType' => $digestType,
            'digest' => $digest,
        ]));
    }

    /**
     * Remove registry side DNSSEC DS data for a domain
     *
     * SOAP operation: DNSSECRemoveDS
     */
    public function DNSSECRemoveDS(
        string $domainName,
        string $UUID,
    ): DNSSECRemoveDSResponse {
        return DNSSECRemoveDSResponse::fromWire($this->client->call('DNSSECRemoveDS', [
            'domainName' => $domainName,
            'UUID' => $UUID,
        ]));
    }

    /**
     * List DNSSEC DS data for a domain
     *
     * SOAP operation: DNSSECListDS
     */
    public function DNSSECListDS(
        string $domainName,
    ): DNSSECListDSResponse {
        return DNSSECListDSResponse::fromWire($this->client->call('DNSSECListDS', [
            'domainName' => $domainName,
        ]));
    }
}
