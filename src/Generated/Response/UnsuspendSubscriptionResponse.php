<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;

/**
 * Generated from the Synergy Wholesale WSDL type "unsuspendSubscriptionResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class UnsuspendSubscriptionResponse implements HydratesFromWire
{
    public function __construct(
        // This response carries only the status envelope.
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(

        );
    }
}
