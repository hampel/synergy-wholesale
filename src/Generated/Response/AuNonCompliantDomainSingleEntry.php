<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "auNonCompliantDomainSingleEntry".
 *
 * Do not edit: run `composer generate` instead.
 */
final class AuNonCompliantDomainSingleEntry implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $domain,
        public readonly ?string $auValidEligibilityLastCheck,
        public readonly ?string $auRegistrantName,
        public readonly ?string $auRegistrantIDType,
        public readonly ?string $auRegistrantID,
        public readonly ?string $auEligibilityType,
        public readonly ?string $auEligibilityName,
        public readonly ?string $auEligibilityIDType,
        public readonly ?string $auEligibilityID,
        public readonly ?string $reason,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            domain: Wire::string($raw, 'domain'),
            auValidEligibilityLastCheck: Wire::string($raw, 'auValidEligibilityLastCheck'),
            auRegistrantName: Wire::string($raw, 'auRegistrantName'),
            auRegistrantIDType: Wire::string($raw, 'auRegistrantIDType'),
            auRegistrantID: Wire::string($raw, 'auRegistrantID'),
            auEligibilityType: Wire::string($raw, 'auEligibilityType'),
            auEligibilityName: Wire::string($raw, 'auEligibilityName'),
            auEligibilityIDType: Wire::string($raw, 'auEligibilityIDType'),
            auEligibilityID: Wire::string($raw, 'auEligibilityID'),
            reason: Wire::string($raw, 'reason'),
        );
    }
}
