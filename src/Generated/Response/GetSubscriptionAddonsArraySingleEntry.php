<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "getSubscriptionAddonsArraySingleEntry".
 *
 * Do not edit: run `composer generate` instead.
 */
final class GetSubscriptionAddonsArraySingleEntry implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $addonId,
        public readonly ?string $addon,
        public readonly ?string $quantity,
        public readonly ?string $monthlyCost,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            addonId: Wire::string($raw, 'addonId'),
            addon: Wire::string($raw, 'addon'),
            quantity: Wire::string($raw, 'quantity'),
            monthlyCost: Wire::string($raw, 'monthlyCost'),
        );
    }
}
