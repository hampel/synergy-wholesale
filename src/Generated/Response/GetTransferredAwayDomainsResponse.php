<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "getTransferredAwayDomainsResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class GetTransferredAwayDomainsResponse implements HydratesFromWire
{
    public function __construct(
        /** @var list<SingleDomainTransferOutboundResponse>|null */
        public readonly ?array $domains,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            domains: Wire::objects($raw, 'domains', SingleDomainTransferOutboundResponse::class),
        );
    }
}
