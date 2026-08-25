<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "listContactsResponseArray".
 *
 * Do not edit: run `composer generate` instead.
 */
final class ListContactsResponseArray implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $organisation,
        public readonly ?string $firstname,
        public readonly ?string $lastname,
        public readonly ?string $address1,
        public readonly ?string $address2,
        public readonly ?string $address3,
        public readonly ?string $suburb,
        public readonly ?string $state,
        public readonly ?string $country,
        public readonly ?string $postcode,
        public readonly ?string $phone,
        public readonly ?string $fax,
        public readonly ?string $email,
        public readonly ?string $us_nexus_cat,
        public readonly ?string $us_nexus_app,
        public readonly ?bool $nz_privacy,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            organisation: Wire::string($raw, 'organisation'),
            firstname: Wire::string($raw, 'firstname'),
            lastname: Wire::string($raw, 'lastname'),
            address1: Wire::string($raw, 'address1'),
            address2: Wire::string($raw, 'address2'),
            address3: Wire::string($raw, 'address3'),
            suburb: Wire::string($raw, 'suburb'),
            state: Wire::string($raw, 'state'),
            country: Wire::string($raw, 'country'),
            postcode: Wire::string($raw, 'postcode'),
            phone: Wire::string($raw, 'phone'),
            fax: Wire::string($raw, 'fax'),
            email: Wire::string($raw, 'email'),
            us_nexus_cat: Wire::string($raw, 'us_nexus_cat'),
            us_nexus_app: Wire::string($raw, 'us_nexus_app'),
            nz_privacy: Wire::bool($raw, 'nz_privacy'),
        );
    }
}
