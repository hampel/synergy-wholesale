<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "hostingEnableTempUrlResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class HostingEnableTempUrlResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $tempUrl,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            tempUrl: Wire::string($raw, 'tempUrl'),
        );
    }
}
