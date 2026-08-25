<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "resendTransferEmailResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class ResendTransferEmailResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?int $statusCode,
        public readonly ?string $reason,
        public readonly ?string $newEmail,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            statusCode: Wire::int($raw, 'statusCode'),
            reason: Wire::string($raw, 'reason'),
            newEmail: Wire::string($raw, 'newEmail'),
        );
    }
}
