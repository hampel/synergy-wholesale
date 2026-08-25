<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "singleDnssecRecord".
 *
 * Do not edit: run `composer generate` instead.
 */
final class SingleDnssecRecord implements HydratesFromWire
{
    public function __construct(
        public readonly ?int $key_tag,
        public readonly ?int $algorithm,
        public readonly ?int $digest_type,
        public readonly ?string $digest,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            key_tag: Wire::int($raw, 'key_tag'),
            algorithm: Wire::int($raw, 'algorithm'),
            digest_type: Wire::int($raw, 'digest_type'),
            digest: Wire::string($raw, 'digest'),
        );
    }
}
