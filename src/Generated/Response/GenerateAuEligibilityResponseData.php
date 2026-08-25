<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "generateAuEligibilityResponseData".
 *
 * Do not edit: run `composer generate` instead.
 */
final class GenerateAuEligibilityResponseData implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $eligibilityType,
        public readonly ?string $registrantID,
        public readonly ?string $registrantIDType,
        public readonly ?string $registrantName,
        public readonly ?string $eligibilityIDType,
        public readonly ?string $eligibilityName,
        public readonly ?string $eligibilityID,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            eligibilityType: Wire::string($raw, 'eligibilityType'),
            registrantID: Wire::string($raw, 'registrantID'),
            registrantIDType: Wire::string($raw, 'registrantIDType'),
            registrantName: Wire::string($raw, 'registrantName'),
            eligibilityIDType: Wire::string($raw, 'eligibilityIDType'),
            eligibilityName: Wire::string($raw, 'eligibilityName'),
            eligibilityID: Wire::string($raw, 'eligibilityID'),
        );
    }
}
