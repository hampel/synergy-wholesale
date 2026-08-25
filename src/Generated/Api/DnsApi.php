<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Api;

use Hampel\SynergyWholesale\Client;
use Hampel\SynergyWholesale\Generated\Response\AddDNSRecordResponse;
use Hampel\SynergyWholesale\Generated\Response\AddDNSZoneResponse;
use Hampel\SynergyWholesale\Generated\Response\DeleteDNSRecordResponse;
use Hampel\SynergyWholesale\Generated\Response\DeleteDNSZoneResponse;
use Hampel\SynergyWholesale\Generated\Response\GetDNSRecordResponse;
use Hampel\SynergyWholesale\Generated\Response\ListDNSZoneResponse;

/**
 * Generated from the Synergy Wholesale WSDL.
 *
 * Do not edit: run `composer generate` instead.
 */
final class DnsApi
{
    public function __construct(private readonly Client $client)
    {
    }

    /**
     * This function will add a new zone for the specified domain name
     *
     * SOAP operation: addDNSZone
     */
    public function addDNSZone(
        string $domainName,
        string $ipAddress,
    ): AddDNSZoneResponse {
        return AddDNSZoneResponse::fromWire($this->client->call('addDNSZone', [
            'domainName' => $domainName,
            'ipAddress' => $ipAddress,
        ]));
    }

    /**
     * This function will delete the zone for the specified domain name
     *
     * SOAP operation: deleteDNSZone
     */
    public function deleteDNSZone(
        string $domainName,
    ): DeleteDNSZoneResponse {
        return DeleteDNSZoneResponse::fromWire($this->client->call('deleteDNSZone', [
            'domainName' => $domainName,
        ]));
    }

    /**
     * This function will add a dns record for the specified zone
     *
     * SOAP operation: addDNSRecord
     */
    public function addDNSRecord(
        string $domainName,
        string $recordName,
        string $recordType,
        string $recordContent,
        int $recordTTL,
        int $recordPrio,
    ): AddDNSRecordResponse {
        return AddDNSRecordResponse::fromWire($this->client->call('addDNSRecord', [
            'domainName' => $domainName,
            'recordName' => $recordName,
            'recordType' => $recordType,
            'recordContent' => $recordContent,
            'recordTTL' => $recordTTL,
            'recordPrio' => $recordPrio,
        ]));
    }

    /**
     * This function will update a dns record for the specified zone and record ID
     *
     * SOAP operation: updateDNSRecord
     */
    public function updateDNSRecord(
        string $domainName,
        string $recordName,
        string $recordType,
        string $recordContent,
        string $recordTTL,
        int $recordPrio,
        string $recordID,
    ): AddDNSRecordResponse {
        return AddDNSRecordResponse::fromWire($this->client->call('updateDNSRecord', [
            'domainName' => $domainName,
            'recordName' => $recordName,
            'recordType' => $recordType,
            'recordContent' => $recordContent,
            'recordTTL' => $recordTTL,
            'recordPrio' => $recordPrio,
            'recordID' => $recordID,
        ]));
    }

    /**
     * This function will delete a dns record from the specified zone
     *
     * SOAP operation: deleteDNSRecord
     */
    public function deleteDNSRecord(
        string $domainName,
        string $recordID,
    ): DeleteDNSRecordResponse {
        return DeleteDNSRecordResponse::fromWire($this->client->call('deleteDNSRecord', [
            'domainName' => $domainName,
            'recordID' => $recordID,
        ]));
    }

    /**
     * This function will retrieve a specific dns record from the specified record id
     *
     * SOAP operation: getDNSRecord
     */
    public function getDNSRecord(
        string $domainName,
        string $recordID,
    ): GetDNSRecordResponse {
        return GetDNSRecordResponse::fromWire($this->client->call('getDNSRecord', [
            'domainName' => $domainName,
            'recordID' => $recordID,
        ]));
    }

    /**
     * This function will list the contents of a specific zone
     *
     * SOAP operation: listDNSZone
     */
    public function listDNSZone(
        string $domainName,
    ): ListDNSZoneResponse {
        return ListDNSZoneResponse::fromWire($this->client->call('listDNSZone', [
            'domainName' => $domainName,
        ]));
    }
}
