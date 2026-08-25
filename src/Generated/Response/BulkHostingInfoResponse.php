<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "bulkHostingInfoResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class BulkHostingInfoResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?int $page,
        public readonly ?int $limit,
        /** @var list<BulkHostingInfoResponseSingleEntry>|null */
        public readonly ?array $hoidList,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            page: Wire::int($raw, 'page'),
            limit: Wire::int($raw, 'limit'),
            hoidList: Wire::objects($raw, 'hoidList', BulkHostingInfoResponseSingleEntry::class),
        );
    }
}
