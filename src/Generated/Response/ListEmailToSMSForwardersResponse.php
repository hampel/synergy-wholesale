<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "listEmailToSMSForwardersResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class ListEmailToSMSForwardersResponse implements HydratesFromWire
{
    public function __construct(
        /** @var list<SingleEmailToSMSForwardersResponse>|null */
        public readonly ?array $forwarders,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            forwarders: Wire::objects($raw, 'forwarders', SingleEmailToSMSForwardersResponse::class),
        );
    }
}
