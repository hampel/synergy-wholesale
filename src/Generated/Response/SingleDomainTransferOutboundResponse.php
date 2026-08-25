<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "singleDomainTransferOutboundResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class SingleDomainTransferOutboundResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $domain_id,
        public readonly ?string $domainname,
        public readonly ?string $registrar,
        public readonly ?string $reseller,
        public readonly ?string $timestamp,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            domain_id: Wire::string($raw, 'domain_id'),
            domainname: Wire::string($raw, 'domainname'),
            registrar: Wire::string($raw, 'registrar'),
            reseller: Wire::string($raw, 'reseller'),
            timestamp: Wire::string($raw, 'timestamp'),
        );
    }
}
