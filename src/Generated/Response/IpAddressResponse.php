<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "ipAddressResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class IpAddressResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $itemName,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            itemName: Wire::string($raw, 'itemName'),
        );
    }
}
