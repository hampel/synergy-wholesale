<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "clientListArraySingleEntry".
 *
 * Do not edit: run `composer generate` instead.
 */
final class ClientListArraySingleEntry implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $clientId,
        public readonly ?string $name,
        public readonly ?string $company,
        public readonly ?string $totalSubscriptions,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            clientId: Wire::string($raw, 'clientId'),
            name: Wire::string($raw, 'name'),
            company: Wire::string($raw, 'company'),
            totalSubscriptions: Wire::string($raw, 'totalSubscriptions'),
        );
    }
}
