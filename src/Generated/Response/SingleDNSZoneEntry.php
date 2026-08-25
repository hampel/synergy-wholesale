<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "singleDNSZoneEntry".
 *
 * Do not edit: run `composer generate` instead.
 */
final class SingleDNSZoneEntry implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $hostName,
        public readonly ?string $type,
        public readonly ?string $content,
        public readonly ?string $ttl,
        public readonly ?string $prio,
        public readonly ?string $id,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            hostName: Wire::string($raw, 'hostName'),
            type: Wire::string($raw, 'type'),
            content: Wire::string($raw, 'content'),
            ttl: Wire::string($raw, 'ttl'),
            prio: Wire::string($raw, 'prio'),
            id: Wire::string($raw, 'id'),
        );
    }
}
