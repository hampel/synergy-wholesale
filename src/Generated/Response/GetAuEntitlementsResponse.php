<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "getAuEntitlementsResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class GetAuEntitlementsResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $contentionType,
        /** @var list<GetAuEntitlementsContentionArraySingleEntry>|null */
        public readonly ?array $contention,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            contentionType: Wire::string($raw, 'contentionType'),
            contention: Wire::objects($raw, 'contention', GetAuEntitlementsContentionArraySingleEntry::class),
        );
    }
}
