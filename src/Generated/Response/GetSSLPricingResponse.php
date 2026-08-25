<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "getSSLPricingResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class GetSSLPricingResponse implements HydratesFromWire
{
    public function __construct(
        /** @var list<SingleSSLPricingResponse>|null */
        public readonly ?array $pricing,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            pricing: Wire::objects($raw, 'pricing', SingleSSLPricingResponse::class),
        );
    }
}
