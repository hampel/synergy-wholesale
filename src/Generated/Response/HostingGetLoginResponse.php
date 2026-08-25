<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "hostingGetLoginResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class HostingGetLoginResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $url,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            url: Wire::string($raw, 'url'),
        );
    }
}
