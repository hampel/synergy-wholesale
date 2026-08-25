<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "getClientResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class GetClientResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $firstname,
        public readonly ?string $lastname,
        public readonly ?string $company,
        public readonly ?string $email,
        public readonly ?string $phone,
        public readonly ?string $address,
        public readonly ?string $address2,
        public readonly ?string $suburb,
        public readonly ?string $postcode,
        public readonly ?string $state,
        public readonly ?string $country,
        public readonly ?string $domainPrefix,
        public readonly ?string $clientStatus,
        public readonly ?string $description,
        public readonly ?bool $agreementStatus,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            firstname: Wire::string($raw, 'firstname'),
            lastname: Wire::string($raw, 'lastname'),
            company: Wire::string($raw, 'company'),
            email: Wire::string($raw, 'email'),
            phone: Wire::string($raw, 'phone'),
            address: Wire::string($raw, 'address'),
            address2: Wire::string($raw, 'address2'),
            suburb: Wire::string($raw, 'suburb'),
            postcode: Wire::string($raw, 'postcode'),
            state: Wire::string($raw, 'state'),
            country: Wire::string($raw, 'country'),
            domainPrefix: Wire::string($raw, 'domainPrefix'),
            clientStatus: Wire::string($raw, 'clientStatus'),
            description: Wire::string($raw, 'description'),
            agreementStatus: Wire::bool($raw, 'agreementStatus'),
        );
    }
}
