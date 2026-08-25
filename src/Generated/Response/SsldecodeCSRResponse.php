<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "SSL_decodeCSRResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class SsldecodeCSRResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $state,
        public readonly ?string $country,
        public readonly ?string $city,
        public readonly ?string $organisationUnit,
        public readonly ?string $organisation,
        public readonly ?string $commonName,
        public readonly ?string $emailAddress,
        /** @var list<string>|null */
        public readonly ?array $subjectAltNames,
        public readonly ?int $privateKeyLength,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            state: Wire::string($raw, 'state'),
            country: Wire::string($raw, 'country'),
            city: Wire::string($raw, 'city'),
            organisationUnit: Wire::string($raw, 'organisationUnit'),
            organisation: Wire::string($raw, 'organisation'),
            commonName: Wire::string($raw, 'commonName'),
            emailAddress: Wire::string($raw, 'emailAddress'),
            subjectAltNames: Wire::strings($raw, 'subjectAltNames'),
            privateKeyLength: Wire::int($raw, 'privateKeyLength'),
        );
    }
}
