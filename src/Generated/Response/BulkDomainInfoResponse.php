<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "bulkDomainInfoResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class BulkDomainInfoResponse implements HydratesFromWire
{
    public function __construct(
        /** @var list<BulkDomainInfoResponseSingleEntry>|null */
        public readonly ?array $domainList,
        public readonly ?int $page,
        public readonly ?int $limit,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            domainList: Wire::objects($raw, 'domainList', BulkDomainInfoResponseSingleEntry::class),
            page: Wire::int($raw, 'page'),
            limit: Wire::int($raw, 'limit'),
        );
    }
}
