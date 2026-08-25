<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "getDomainEligibilityFieldsEntry".
 *
 * Do not edit: run `composer generate` instead.
 */
final class GetDomainEligibilityFieldsEntry implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $name,
        public readonly ?string $title,
        public readonly ?string $description,
        public readonly ?int $required,
        public readonly ?string $policySummary,
        /** @var list<GetDomainEligibilityFieldsOptionsEntry>|null */
        public readonly ?array $options,
        public readonly ?string $type,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            name: Wire::string($raw, 'name'),
            title: Wire::string($raw, 'title'),
            description: Wire::string($raw, 'description'),
            required: Wire::int($raw, 'required'),
            policySummary: Wire::string($raw, 'policySummary'),
            options: Wire::objects($raw, 'options', GetDomainEligibilityFieldsOptionsEntry::class),
            type: Wire::string($raw, 'type'),
        );
    }
}
