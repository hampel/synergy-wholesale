<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "listDomainCategoriesResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class ListDomainCategoriesResponse implements HydratesFromWire
{
    public function __construct(
        /** @var list<DomainCategorySingleEntry>|null */
        public readonly ?array $domainCategories,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            domainCategories: Wire::objects($raw, 'domainCategories', DomainCategorySingleEntry::class),
        );
    }
}
