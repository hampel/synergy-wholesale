<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "domainListArraySingleEntry".
 *
 * Do not edit: run `composer generate` instead.
 */
final class DomainListArraySingleEntry implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $domain,
        public readonly ?bool $available,
        public readonly ?string $costPrice,
        public readonly ?string $basePrice,
        public readonly ?bool $premium,
        public readonly ?bool $requiresMembership,
        public readonly ?bool $requiresApplication,
        public readonly ?bool $preorderAvailable,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            domain: Wire::string($raw, 'domain'),
            available: Wire::bool($raw, 'available'),
            costPrice: Wire::string($raw, 'costPrice'),
            basePrice: Wire::string($raw, 'basePrice'),
            premium: Wire::bool($raw, 'premium'),
            requiresMembership: Wire::bool($raw, 'requiresMembership'),
            requiresApplication: Wire::bool($raw, 'requiresApplication'),
            preorderAvailable: Wire::bool($raw, 'preorderAvailable'),
        );
    }
}
