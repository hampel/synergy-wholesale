<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "rawDomainInfoResponseSingle".
 *
 * Do not edit: run `composer generate` instead.
 */
final class RawDomainInfoResponseSingle implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $domain,
        /** @var list<string>|null */
        public readonly ?array $domainStatus,
        /** @var list<string>|null */
        public readonly ?array $nameservers,
        public readonly ?string $expiryDate,
        public readonly ?ContactArray $contact,
        public readonly ?string $errorMessage,
        public readonly ?string $status,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            domain: Wire::string($raw, 'domain'),
            domainStatus: Wire::strings($raw, 'domainStatus'),
            nameservers: Wire::strings($raw, 'nameservers'),
            expiryDate: Wire::string($raw, 'expiryDate'),
            contact: Wire::object($raw, 'contact', ContactArray::class),
            errorMessage: Wire::string($raw, 'errorMessage'),
            status: Wire::string($raw, 'status'),
        );
    }
}
