<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "passwordRequirementsResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class PasswordRequirementsResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?int $minimumLength,
        public readonly ?int $maximumLength,
        public readonly ?string $complexity,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            minimumLength: Wire::int($raw, 'minimumLength'),
            maximumLength: Wire::int($raw, 'maximumLength'),
            complexity: Wire::string($raw, 'complexity'),
        );
    }
}
