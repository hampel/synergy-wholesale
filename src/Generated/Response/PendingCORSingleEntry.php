<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "pendingCORSingleEntry".
 *
 * Do not edit: run `composer generate` instead.
 */
final class PendingCORSingleEntry implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $domainName,
        public readonly ?int $step,
        public readonly ?string $status,
        public readonly ?int $renewYear,
        public readonly ?string $createdDate,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            domainName: Wire::string($raw, 'domainName'),
            step: Wire::int($raw, 'step'),
            status: Wire::string($raw, 'status'),
            renewYear: Wire::int($raw, 'renewYear'),
            createdDate: Wire::string($raw, 'createdDate'),
        );
    }
}
