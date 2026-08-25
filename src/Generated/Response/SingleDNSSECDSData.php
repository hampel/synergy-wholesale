<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "singleDNSSECDSData".
 *
 * Do not edit: run `composer generate` instead.
 */
final class SingleDNSSECDSData implements HydratesFromWire
{
    public function __construct(
        public readonly ?int $keyTag,
        public readonly ?int $algorithm,
        public readonly ?string $digest,
        public readonly ?int $digestType,
        public readonly ?string $UUID,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            keyTag: Wire::int($raw, 'keyTag'),
            algorithm: Wire::int($raw, 'algorithm'),
            digest: Wire::string($raw, 'digest'),
            digestType: Wire::int($raw, 'digestType'),
            UUID: Wire::string($raw, 'UUID'),
        );
    }
}
