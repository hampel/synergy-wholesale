<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "getSubscriptionTasksArraySingleEntry".
 *
 * Do not edit: run `composer generate` instead.
 */
final class GetSubscriptionTasksArraySingleEntry implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $action,
        public readonly ?string $last_updated,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            action: Wire::string($raw, 'action'),
            last_updated: Wire::string($raw, 'last_updated'),
        );
    }
}
