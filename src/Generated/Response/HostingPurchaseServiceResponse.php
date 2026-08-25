<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "hostingPurchaseServiceResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class HostingPurchaseServiceResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $username,
        public readonly ?string $domain,
        public readonly ?string $password,
        public readonly ?string $hoid,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            username: Wire::string($raw, 'username'),
            domain: Wire::string($raw, 'domain'),
            password: Wire::string($raw, 'password'),
            hoid: Wire::string($raw, 'hoid'),
        );
    }
}
