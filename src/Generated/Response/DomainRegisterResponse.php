<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "domainRegisterResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class DomainRegisterResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $costPrice,
        public readonly ?string $pendingId,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            costPrice: Wire::string($raw, 'costPrice'),
            pendingId: Wire::string($raw, 'pendingId'),
        );
    }
}
