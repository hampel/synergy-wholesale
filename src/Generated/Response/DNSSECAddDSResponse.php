<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "DNSSECAddDSResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class DNSSECAddDSResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $UUID,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            UUID: Wire::string($raw, 'UUID'),
        );
    }
}
