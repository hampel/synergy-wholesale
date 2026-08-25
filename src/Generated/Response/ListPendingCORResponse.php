<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "listPendingCORResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class ListPendingCORResponse implements HydratesFromWire
{
    public function __construct(
        /** @var list<PendingCORSingleEntry>|null */
        public readonly ?array $pendingCOR,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            pendingCOR: Wire::objects($raw, 'pendingCOR', PendingCORSingleEntry::class),
        );
    }
}
