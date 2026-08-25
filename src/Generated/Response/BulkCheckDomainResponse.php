<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "bulkCheckDomainResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class BulkCheckDomainResponse implements HydratesFromWire
{
    public function __construct(
        /** @var list<DomainListArraySingleEntry>|null */
        public readonly ?array $domainList,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            domainList: Wire::objects($raw, 'domainList', DomainListArraySingleEntry::class),
        );
    }
}
