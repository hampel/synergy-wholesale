<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "hostingGetServiceResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class HostingGetServiceResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $domain,
        public readonly ?string $username,
        public readonly ?string $server,
        public readonly ?string $plan,
        public readonly ?string $planID,
        public readonly ?string $product,
        public readonly ?string $locationID,
        public readonly ?string $billingPeriod,
        public readonly ?string $nextRenewalDue,
        public readonly ?string $city,
        public readonly ?string $country,
        public readonly ?string $dedicatedIPv4,
        public readonly ?string $password,
        public readonly ?string $diskUsage,
        public readonly ?int $bandwidth,
        public readonly ?bool $tempUrl,
        public readonly ?string $tempUrlDate,
        public readonly ?string $serverIPAddress,
        /** @var list<string>|null */
        public readonly ?array $nameServers,
        public readonly ?string $diskLimit,
        public readonly ?string $mxrecords,
        public readonly ?string $bandwidthLimit,
        public readonly ?string $dkim,
        public readonly ?string $activeSync,
        public readonly ?string $mailboxUsage,
        public readonly ?string $firstName,
        public readonly ?string $lastName,
        public readonly ?string $createdDate,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            domain: Wire::string($raw, 'domain'),
            username: Wire::string($raw, 'username'),
            server: Wire::string($raw, 'server'),
            plan: Wire::string($raw, 'plan'),
            planID: Wire::string($raw, 'planID'),
            product: Wire::string($raw, 'product'),
            locationID: Wire::string($raw, 'locationID'),
            billingPeriod: Wire::string($raw, 'billingPeriod'),
            nextRenewalDue: Wire::string($raw, 'nextRenewalDue'),
            city: Wire::string($raw, 'city'),
            country: Wire::string($raw, 'country'),
            dedicatedIPv4: Wire::string($raw, 'dedicatedIPv4'),
            password: Wire::string($raw, 'password'),
            diskUsage: Wire::string($raw, 'diskUsage'),
            bandwidth: Wire::int($raw, 'bandwidth'),
            tempUrl: Wire::bool($raw, 'tempUrl'),
            tempUrlDate: Wire::string($raw, 'tempUrlDate'),
            serverIPAddress: Wire::string($raw, 'serverIPAddress'),
            nameServers: Wire::strings($raw, 'nameServers'),
            diskLimit: Wire::string($raw, 'diskLimit'),
            mxrecords: Wire::string($raw, 'mxrecords'),
            bandwidthLimit: Wire::string($raw, 'bandwidthLimit'),
            dkim: Wire::string($raw, 'dkim'),
            activeSync: Wire::string($raw, 'activeSync'),
            mailboxUsage: Wire::string($raw, 'mailboxUsage'),
            firstName: Wire::string($raw, 'firstName'),
            lastName: Wire::string($raw, 'lastName'),
            createdDate: Wire::string($raw, 'createdDate'),
        );
    }
}
