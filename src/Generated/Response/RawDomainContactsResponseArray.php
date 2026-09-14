<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "rawDomainContactsResponseArray".
 *
 * Do not edit: run `composer generate` instead.
 */
final class RawDomainContactsResponseArray implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $organisation,
        public readonly ?string $name,
        /** @var list<string>|null */
        public readonly ?array $street,
        public readonly ?string $city,
        /** @var list<string>|null */
        public readonly ?array $status,
        public readonly ?string $id,
        public readonly ?string $state,
        public readonly ?string $country,
        public readonly ?string $postcode,
        public readonly ?string $voice,
        public readonly ?string $email,
        public readonly ?string $us_nexus_cat,
        public readonly ?string $us_nexus_app,
        public readonly ?bool $nz_privacy,
        public readonly ?string $clID,
        public readonly ?string $roid,
        public readonly ?string $authinfo,
        public readonly ?string $crDate,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            organisation: Wire::string($raw, 'organisation'),
            name: Wire::string($raw, 'name'),
            street: Wire::strings($raw, 'street'),
            city: Wire::string($raw, 'city'),
            status: Wire::strings($raw, 'status'),
            id: Wire::string($raw, 'id'),
            state: Wire::string($raw, 'state'),
            country: Wire::string($raw, 'country'),
            postcode: Wire::string($raw, 'postcode'),
            voice: Wire::string($raw, 'voice'),
            email: Wire::string($raw, 'email'),
            us_nexus_cat: Wire::string($raw, 'us_nexus_cat'),
            us_nexus_app: Wire::string($raw, 'us_nexus_app'),
            nz_privacy: Wire::bool($raw, 'nz_privacy'),
            clID: Wire::string($raw, 'clID'),
            roid: Wire::string($raw, 'roid'),
            authinfo: Wire::string($raw, 'authinfo'),
            crDate: Wire::string($raw, 'crDate'),
        );
    }
}
