<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "listAvailableDomainExtensionsResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class ListAvailableDomainExtensionsResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $reason,
        /** @var list<ListAvailableDomainExtensionsResponseSingleEntry>|null */
        public readonly ?array $extensions,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            reason: Wire::string($raw, 'reason'),
            extensions: Wire::objects($raw, 'extensions', ListAvailableDomainExtensionsResponseSingleEntry::class),
        );
    }
}
