<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "checkDomainResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class CheckDomainResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?int $available,
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
            available: Wire::int($raw, 'available'),
            costPrice: Wire::string($raw, 'costPrice'),
            basePrice: Wire::string($raw, 'basePrice'),
            premium: Wire::bool($raw, 'premium'),
            requiresMembership: Wire::bool($raw, 'requiresMembership'),
            requiresApplication: Wire::bool($raw, 'requiresApplication'),
            preorderAvailable: Wire::bool($raw, 'preorderAvailable'),
        );
    }
}
