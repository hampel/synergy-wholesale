<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "getDomainEligibilityFieldsResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class GetDomainEligibilityFieldsResponse implements HydratesFromWire
{
    public function __construct(
        /** @var list<GetDomainEligibilityFieldsEntry>|null */
        public readonly ?array $fields,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            fields: Wire::objects($raw, 'fields', GetDomainEligibilityFieldsEntry::class),
        );
    }
}
