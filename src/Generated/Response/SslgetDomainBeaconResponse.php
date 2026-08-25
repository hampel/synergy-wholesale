<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "SSL_getDomainBeaconResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class SslgetDomainBeaconResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $filename,
        public readonly ?string $beacon,
        public readonly ?string $domain,
        public readonly ?SslgetBeaconResponseDNS $dns,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            filename: Wire::string($raw, 'filename'),
            beacon: Wire::string($raw, 'beacon'),
            domain: Wire::string($raw, 'domain'),
            dns: Wire::object($raw, 'dns', SslgetBeaconResponseDNS::class),
        );
    }
}
