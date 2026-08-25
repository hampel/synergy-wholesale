<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "packageListArraySingleEntry".
 *
 * Do not edit: run `composer generate` instead.
 */
final class PackageListArraySingleEntry implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $name,
        public readonly ?string $product,
        public readonly ?string $price,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            name: Wire::string($raw, 'name'),
            product: Wire::string($raw, 'product'),
            price: Wire::string($raw, 'price'),
        );
    }
}
