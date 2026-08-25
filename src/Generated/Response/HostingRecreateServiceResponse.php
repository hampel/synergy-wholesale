<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "hostingRecreateServiceResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class HostingRecreateServiceResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $password,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            password: Wire::string($raw, 'password'),
        );
    }
}
