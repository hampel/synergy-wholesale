<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "singleEmailToSMSForwardersResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class SingleEmailToSMSForwardersResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $forwarderID,
        public readonly ?string $sourceEmail,
        public readonly ?string $senderID,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            forwarderID: Wire::string($raw, 'forwarderID'),
            sourceEmail: Wire::string($raw, 'sourceEmail'),
            senderID: Wire::string($raw, 'senderID'),
        );
    }
}
