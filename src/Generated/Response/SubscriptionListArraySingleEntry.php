<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "subscriptionListArraySingleEntry".
 *
 * Do not edit: run `composer generate` instead.
 */
final class SubscriptionListArraySingleEntry implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $subscriptionId,
        public readonly ?string $productId,
        public readonly ?string $productName,
        public readonly ?string $productDescription,
        public readonly ?string $productType,
        public readonly ?string $monthlyCost,
        public readonly ?string $quantity,
        public readonly ?string $subscriptionStatus,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            subscriptionId: Wire::string($raw, 'subscriptionId'),
            productId: Wire::string($raw, 'productId'),
            productName: Wire::string($raw, 'productName'),
            productDescription: Wire::string($raw, 'productDescription'),
            productType: Wire::string($raw, 'productType'),
            monthlyCost: Wire::string($raw, 'monthlyCost'),
            quantity: Wire::string($raw, 'quantity'),
            subscriptionStatus: Wire::string($raw, 'subscriptionStatus'),
        );
    }
}
