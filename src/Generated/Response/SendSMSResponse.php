<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "sendSMSResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class SendSMSResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?int $msgCount,
        public readonly ?string $perMsgCost,
        public readonly ?string $totalMsgCost,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            msgCount: Wire::int($raw, 'msgCount'),
            perMsgCost: Wire::string($raw, 'perMsgCost'),
            totalMsgCost: Wire::string($raw, 'totalMsgCost'),
        );
    }
}
