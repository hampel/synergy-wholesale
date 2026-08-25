<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "getSimpleURLForwardsResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class GetSimpleURLForwardsResponse implements HydratesFromWire
{
    public function __construct(
        /** @var list<SingleSimpleURLForwardEntry>|null */
        public readonly ?array $records,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            records: Wire::objects($raw, 'records', SingleSimpleURLForwardEntry::class),
        );
    }
}
