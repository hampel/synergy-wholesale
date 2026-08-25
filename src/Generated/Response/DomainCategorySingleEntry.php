<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "domainCategorySingleEntry".
 *
 * Do not edit: run `composer generate` instead.
 */
final class DomainCategorySingleEntry implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $id,
        public readonly ?string $name,
        public readonly ?string $note,
        public readonly ?string $createdDate,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            id: Wire::string($raw, 'id'),
            name: Wire::string($raw, 'name'),
            note: Wire::string($raw, 'note'),
            createdDate: Wire::string($raw, 'createdDate'),
        );
    }
}
