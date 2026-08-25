<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "businessCheckRegistrationResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class BusinessCheckRegistrationResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $registrationNumber,
        public readonly ?string $registrationState,
        public readonly ?string $entityStatus,
        public readonly ?string $asicNumber,
        public readonly ?string $entityName,
        public readonly ?string $entityTypeCode,
        public readonly ?string $tradingName,
        public readonly ?string $legalName,
        public readonly ?string $organisationType,
        public readonly ?string $state,
        public readonly ?string $postcode,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            registrationNumber: Wire::string($raw, 'registrationNumber'),
            registrationState: Wire::string($raw, 'registrationState'),
            entityStatus: Wire::string($raw, 'entityStatus'),
            asicNumber: Wire::string($raw, 'asicNumber'),
            entityName: Wire::string($raw, 'entityName'),
            entityTypeCode: Wire::string($raw, 'entityTypeCode'),
            tradingName: Wire::string($raw, 'tradingName'),
            legalName: Wire::string($raw, 'legalName'),
            organisationType: Wire::string($raw, 'organisationType'),
            state: Wire::string($raw, 'state'),
            postcode: Wire::string($raw, 'postcode'),
        );
    }
}
