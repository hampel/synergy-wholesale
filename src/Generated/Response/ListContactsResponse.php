<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "listContactsResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class ListContactsResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?ListContactsResponseArray $registrant,
        public readonly ?ListContactsResponseArray $admin,
        public readonly ?ListContactsResponseArray $tech,
        public readonly ?ListContactsResponseArray $billing,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            registrant: Wire::object($raw, 'registrant', ListContactsResponseArray::class),
            admin: Wire::object($raw, 'admin', ListContactsResponseArray::class),
            tech: Wire::object($raw, 'tech', ListContactsResponseArray::class),
            billing: Wire::object($raw, 'billing', ListContactsResponseArray::class),
        );
    }
}
