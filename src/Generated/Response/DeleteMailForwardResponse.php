<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "deleteMailForwardResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class DeleteMailForwardResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?int $statusCode,
        public readonly ?string $reason,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            statusCode: Wire::int($raw, 'statusCode'),
            reason: Wire::string($raw, 'reason'),
        );
    }
}
