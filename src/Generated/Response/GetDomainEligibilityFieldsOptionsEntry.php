<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "getDomainEligibilityFieldsOptionsEntry".
 *
 * Do not edit: run `composer generate` instead.
 */
final class GetDomainEligibilityFieldsOptionsEntry implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $value,
        public readonly ?string $description,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            value: Wire::string($raw, 'value'),
            description: Wire::string($raw, 'description'),
        );
    }
}
