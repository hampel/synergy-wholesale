<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "DNSSECListDSResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class DNSSECListDSResponse implements HydratesFromWire
{
    public function __construct(
        /** @var list<SingleDNSSECDSData>|null */
        public readonly ?array $DSData,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            DSData: Wire::objects($raw, 'DSData', SingleDNSSECDSData::class),
        );
    }
}
