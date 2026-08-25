<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "getUSNexusDataResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class GetUSNexusDataResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $nexusCategory,
        public readonly ?string $nexusApplication,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            nexusCategory: Wire::string($raw, 'nexusCategory'),
            nexusApplication: Wire::string($raw, 'nexusApplication'),
        );
    }
}
