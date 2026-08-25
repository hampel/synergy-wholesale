<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "renewDomainResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class RenewDomainResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $costPrice,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            costPrice: Wire::string($raw, 'costPrice'),
        );
    }
}
