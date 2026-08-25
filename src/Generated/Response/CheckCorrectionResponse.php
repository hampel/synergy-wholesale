<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "checkCorrectionResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class CheckCorrectionResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?bool $isEligibleForCorrection,
        public readonly ?bool $isPendingCorrection,
        public readonly ?string $pendingCorrectionStatus,
        public readonly ?string $pendingCorrectionLink,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            isEligibleForCorrection: Wire::bool($raw, 'isEligibleForCorrection'),
            isPendingCorrection: Wire::bool($raw, 'isPendingCorrection'),
            pendingCorrectionStatus: Wire::string($raw, 'pendingCorrectionStatus'),
            pendingCorrectionLink: Wire::string($raw, 'pendingCorrectionLink'),
        );
    }
}
