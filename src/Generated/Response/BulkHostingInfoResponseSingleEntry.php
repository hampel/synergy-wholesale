<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "bulkHostingInfoResponseSingleEntry".
 *
 * Do not edit: run `composer generate` instead.
 */
final class BulkHostingInfoResponseSingleEntry implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $status,
        public readonly ?string $domain,
        public readonly ?string $hoid,
        public readonly ?string $username,
        public readonly ?string $password,
        public readonly ?string $dedicatedIPv4,
        public readonly ?string $serviceStatus,
        public readonly ?string $server,
        public readonly ?string $plan,
        public readonly ?string $planID,
        public readonly ?string $locationID,
        public readonly ?string $billingPeriod,
        public readonly ?string $nextRenewalDue,
        public readonly ?string $city,
        public readonly ?string $country,
        public readonly ?string $serverIPAddress,
        public readonly ?bool $tempUrl,
        public readonly ?string $tempUrlDate,
        public readonly ?string $diskUsage,
        public readonly ?string $diskLimit,
        public readonly ?int $bandwidth,
        public readonly ?string $bandwidthLimit,
        /** @var list<string>|null */
        public readonly ?array $nameServers,
        public readonly ?string $createdDate,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            status: Wire::string($raw, 'status'),
            domain: Wire::string($raw, 'domain'),
            hoid: Wire::string($raw, 'hoid'),
            username: Wire::string($raw, 'username'),
            password: Wire::string($raw, 'password'),
            dedicatedIPv4: Wire::string($raw, 'dedicatedIPv4'),
            serviceStatus: Wire::string($raw, 'serviceStatus'),
            server: Wire::string($raw, 'server'),
            plan: Wire::string($raw, 'plan'),
            planID: Wire::string($raw, 'planID'),
            locationID: Wire::string($raw, 'locationID'),
            billingPeriod: Wire::string($raw, 'billingPeriod'),
            nextRenewalDue: Wire::string($raw, 'nextRenewalDue'),
            city: Wire::string($raw, 'city'),
            country: Wire::string($raw, 'country'),
            serverIPAddress: Wire::string($raw, 'serverIPAddress'),
            tempUrl: Wire::bool($raw, 'tempUrl'),
            tempUrlDate: Wire::string($raw, 'tempUrlDate'),
            diskUsage: Wire::string($raw, 'diskUsage'),
            diskLimit: Wire::string($raw, 'diskLimit'),
            bandwidth: Wire::int($raw, 'bandwidth'),
            bandwidthLimit: Wire::string($raw, 'bandwidthLimit'),
            nameServers: Wire::strings($raw, 'nameServers'),
            createdDate: Wire::string($raw, 'createdDate'),
        );
    }
}
