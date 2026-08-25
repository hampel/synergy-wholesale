<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "listClientsResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class ListClientsResponse implements HydratesFromWire
{
    public function __construct(
        /** @var list<list<ClientListArraySingleEntry>>|null */
        public readonly ?array $clientsList,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            clientsList: Wire::objectLists($raw, 'clientsList', ClientListArraySingleEntry::class),
        );
    }
}
