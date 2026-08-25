<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "updateSubscriptionQuantityResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class UpdateSubscriptionQuantityResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $newMonthlyCost,
        public readonly ?string $cost,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            newMonthlyCost: Wire::string($raw, 'newMonthlyCost'),
            cost: Wire::string($raw, 'cost'),
        );
    }
}
