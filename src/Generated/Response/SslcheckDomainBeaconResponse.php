<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "SSL_checkDomainBeaconResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class SslcheckDomainBeaconResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $beacon,
        public readonly ?string $domain,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            beacon: Wire::string($raw, 'beacon'),
            domain: Wire::string($raw, 'domain'),
        );
    }
}
