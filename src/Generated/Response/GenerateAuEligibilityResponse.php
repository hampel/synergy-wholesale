<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "generateAuEligibilityResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class GenerateAuEligibilityResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?GenerateAuEligibilityResponseData $eligibility,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            eligibility: Wire::object($raw, 'eligibility', GenerateAuEligibilityResponseData::class),
        );
    }
}
