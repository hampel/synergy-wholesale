<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Api;

use Hampel\SynergyWholesale\Client;
use Hampel\SynergyWholesale\Generated\Response\AddHostIPResponse;
use Hampel\SynergyWholesale\Generated\Response\AddHostResponse;
use Hampel\SynergyWholesale\Generated\Response\BulkHostingInfoResponse;
use Hampel\SynergyWholesale\Generated\Response\DeleteHostIPResponse;
use Hampel\SynergyWholesale\Generated\Response\DeleteHostResponse;
use Hampel\SynergyWholesale\Generated\Response\ListAllHostsResponse;
use Hampel\SynergyWholesale\Generated\Response\ListHostResponse;

/**
 * Generated from the Synergy Wholesale WSDL.
 *
 * Do not edit: run `composer generate` instead.
 */
final class RegistryHostsApi
{
    public function __construct(private readonly Client $client)
    {
    }

    /**
     * This function will list a host entry to the system
     *
     * SOAP operation: listHost
     */
    public function listHost(
        string $host,
        string $domainName,
    ): ListHostResponse {
        return ListHostResponse::fromWire($this->client->call('listHost', [
            'host' => $host,
            'domainName' => $domainName,
        ]));
    }

    /**
     * This function will list all host entries for a domain
     *
     * SOAP operation: listAllHosts
     */
    public function listAllHosts(
        string $domainName,
    ): ListAllHostsResponse {
        return ListAllHostsResponse::fromWire($this->client->call('listAllHosts', [
            'domainName' => $domainName,
        ]));
    }

    /**
     * This function will add a host entry to the system
     *
     * @param list<string> $ipAddress
     *
     * SOAP operation: addHost
     */
    public function addHost(
        string $host,
        string $domainName,
        array $ipAddress,
    ): AddHostResponse {
        return AddHostResponse::fromWire($this->client->call('addHost', [
            'host' => $host,
            'domainName' => $domainName,
            'ipAddress' => $ipAddress,
        ]));
    }

    /**
     * This function will delete a host entry to the system
     *
     * SOAP operation: deleteHost
     */
    public function deleteHost(
        string $host,
        string $domainName,
    ): DeleteHostResponse {
        return DeleteHostResponse::fromWire($this->client->call('deleteHost', [
            'host' => $host,
            'domainName' => $domainName,
        ]));
    }

    /**
     * This function will add a IP to a host entry to the system
     *
     * @param list<string> $ipAddress
     *
     * SOAP operation: addHostIP
     */
    public function addHostIP(
        string $host,
        string $domainName,
        array $ipAddress,
    ): AddHostIPResponse {
        return AddHostIPResponse::fromWire($this->client->call('addHostIP', [
            'host' => $host,
            'domainName' => $domainName,
            'ipAddress' => $ipAddress,
        ]));
    }

    /**
     * This function will remove a IP from a host entry
     *
     * @param list<string> $ipAddress
     *
     * SOAP operation: deleteHostIP
     */
    public function deleteHostIP(
        string $host,
        string $domainName,
        array $ipAddress,
    ): DeleteHostIPResponse {
        return DeleteHostIPResponse::fromWire($this->client->call('deleteHostIP', [
            'host' => $host,
            'domainName' => $domainName,
            'ipAddress' => $ipAddress,
        ]));
    }

    /**
     * Will return the hosting service information for the provided list of hosting identifiers
     *
     * @param list<string> $hoidList
     *
     * SOAP operation: bulkHostingInfo
     *
     * @deprecated use $sw->hosting()->bulkHostingInfo() instead. This group
     *             keeps it until the next major version.
     */
    public function bulkHostingInfo(
        array $hoidList,
    ): BulkHostingInfoResponse {
        return (new HostingApi($this->client))->bulkHostingInfo(hoidList: $hoidList);
    }

    /**
     * Will return a paginated result set of hosting services in your account
     *
     * SOAP operation: listHosting
     *
     * @deprecated use $sw->hosting()->listHosting() instead. This group
     *             keeps it until the next major version.
     */
    public function listHosting(
        ?string $status = null,
        ?int $page = null,
        ?int $limit = null,
    ): BulkHostingInfoResponse {
        return (new HostingApi($this->client))->listHosting(status: $status, page: $page, limit: $limit);
    }
}
