<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "hostingListPackagesResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class HostingListPackagesResponse implements HydratesFromWire
{
    public function __construct(
        /** @var list<PackageListArraySingleEntry>|null */
        public readonly ?array $packages,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            packages: Wire::objects($raw, 'packages', PackageListArraySingleEntry::class),
        );
    }
}
