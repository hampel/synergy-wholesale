<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "createClientResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class CreateClientResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $identifier,
        public readonly ?string $domainPrefix,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            identifier: Wire::string($raw, 'identifier'),
            domainPrefix: Wire::string($raw, 'domainPrefix'),
        );
    }
}
