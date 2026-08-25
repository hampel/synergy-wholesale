<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "listDNSZoneResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class ListDNSZoneResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $statusCode,
        public readonly ?string $reason,
        /** @var list<SingleDNSZoneEntry>|null */
        public readonly ?array $records,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            statusCode: Wire::string($raw, 'statusCode'),
            reason: Wire::string($raw, 'reason'),
            records: Wire::objects($raw, 'records', SingleDNSZoneEntry::class),
        );
    }
}
