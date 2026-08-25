<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "listAllHostsResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class ListAllHostsResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?int $statusCode,
        public readonly ?string $reason,
        /** @var list<SingleHostResponse>|null */
        public readonly ?array $hosts,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            statusCode: Wire::int($raw, 'statusCode'),
            reason: Wire::string($raw, 'reason'),
            hosts: Wire::objects($raw, 'hosts', SingleHostResponse::class),
        );
    }
}
