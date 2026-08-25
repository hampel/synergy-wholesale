<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "subscriptionProductListArraySingleEntry".
 *
 * Do not edit: run `composer generate` instead.
 */
final class SubscriptionProductListArraySingleEntry implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $productId,
        public readonly ?string $productName,
        public readonly ?string $productDescription,
        public readonly ?string $productType,
        public readonly ?string $monthlyCost,
        public readonly ?string $maxSeats,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            productId: Wire::string($raw, 'productId'),
            productName: Wire::string($raw, 'productName'),
            productDescription: Wire::string($raw, 'productDescription'),
            productType: Wire::string($raw, 'productType'),
            monthlyCost: Wire::string($raw, 'monthlyCost'),
            maxSeats: Wire::string($raw, 'maxSeats'),
        );
    }
}
