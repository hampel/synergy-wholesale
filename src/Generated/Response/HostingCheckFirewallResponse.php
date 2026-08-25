<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "hostingCheckFirewallResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class HostingCheckFirewallResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?bool $blocked,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            blocked: Wire::bool($raw, 'blocked'),
        );
    }
}
