<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "singleHostResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class SingleHostResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $hostName,
        /** @var list<string>|null */
        public readonly ?array $ip,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            hostName: Wire::string($raw, 'hostName'),
            ip: Wire::strings($raw, 'ip'),
        );
    }
}
