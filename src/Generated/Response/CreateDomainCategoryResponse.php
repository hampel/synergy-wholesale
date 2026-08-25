<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "createDomainCategoryResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class CreateDomainCategoryResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?DomainCategorySingleEntry $category,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            category: Wire::object($raw, 'category', DomainCategorySingleEntry::class),
        );
    }
}
