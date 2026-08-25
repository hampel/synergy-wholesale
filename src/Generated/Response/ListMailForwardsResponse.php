<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "listMailForwardsResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class ListMailForwardsResponse implements HydratesFromWire
{
    public function __construct(
        /** @var list<SingleMailForwardEntry>|null */
        public readonly ?array $forwards,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            forwards: Wire::objects($raw, 'forwards', SingleMailForwardEntry::class),
        );
    }
}
