<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "singleMailForwardEntry".
 *
 * Do not edit: run `composer generate` instead.
 */
final class SingleMailForwardEntry implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $source,
        public readonly ?string $destination,
        public readonly ?int $id,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            source: Wire::string($raw, 'source'),
            destination: Wire::string($raw, 'destination'),
            id: Wire::int($raw, 'id'),
        );
    }
}
