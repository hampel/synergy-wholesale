<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "isDomainTransferrableResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class IsDomainTransferrableResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?bool $internalTransfer,
        public readonly ?string $expiry,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            internalTransfer: Wire::bool($raw, 'internalTransfer'),
            expiry: Wire::string($raw, 'expiry'),
        );
    }
}
