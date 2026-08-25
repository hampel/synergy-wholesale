<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "addSimpleURLForwardResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class AddSimpleURLForwardResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?string $hostname,
        public readonly ?string $url,
        public readonly ?string $redirecttype,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            id: Wire::int($raw, 'id'),
            hostname: Wire::string($raw, 'hostname'),
            url: Wire::string($raw, 'url'),
            redirecttype: Wire::string($raw, 'redirecttype'),
        );
    }
}
