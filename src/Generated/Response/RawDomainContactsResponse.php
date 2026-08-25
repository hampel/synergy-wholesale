<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "rawDomainContactsResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class RawDomainContactsResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?RawDomainContactsResponseArray $registrant,
        public readonly ?RawDomainContactsResponseArray $admin,
        public readonly ?RawDomainContactsResponseArray $tech,
        public readonly ?RawDomainContactsResponseArray $billing,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            registrant: Wire::object($raw, 'registrant', RawDomainContactsResponseArray::class),
            admin: Wire::object($raw, 'admin', RawDomainContactsResponseArray::class),
            tech: Wire::object($raw, 'tech', RawDomainContactsResponseArray::class),
            billing: Wire::object($raw, 'billing', RawDomainContactsResponseArray::class),
        );
    }
}
