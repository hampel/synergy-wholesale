<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "hostingChangePackageResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class HostingChangePackageResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $newAmount,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            newAmount: Wire::string($raw, 'newAmount'),
        );
    }
}
