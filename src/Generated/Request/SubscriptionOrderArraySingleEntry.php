<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Request;

/**
 * Generated from the Synergy Wholesale WSDL type "subscriptionOrderArraySingleEntry".
 *
 * Do not edit: run `composer generate` instead.
 */
final class SubscriptionOrderArraySingleEntry
{
    public function __construct(
        public readonly string $productId,
        public readonly string $quantity,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toWire(): array
    {
        return [
            'productId' => $this->productId,
            'quantity' => $this->quantity,
        ];
    }
}
