<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "canRenewDomainResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class CanRenewDomainResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?int $yearsCanRenewFor,
        public readonly ?string $redemptionUntil,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            yearsCanRenewFor: Wire::int($raw, 'yearsCanRenewFor'),
            redemptionUntil: Wire::string($raw, 'redemptionUntil'),
        );
    }
}
