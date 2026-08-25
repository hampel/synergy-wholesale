<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "SSL_getBeaconResponseDNS".
 *
 * Do not edit: run `composer generate` instead.
 */
final class SslgetBeaconResponseDNS implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $type,
        public readonly ?string $hostName,
        public readonly ?string $content,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            type: Wire::string($raw, 'type'),
            hostName: Wire::string($raw, 'hostName'),
            content: Wire::string($raw, 'content'),
        );
    }
}
