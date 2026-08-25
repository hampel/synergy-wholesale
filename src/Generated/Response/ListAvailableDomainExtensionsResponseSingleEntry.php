<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "listAvailableDomainExtensionsResponseSingleEntry".
 *
 * Do not edit: run `composer generate` instead.
 */
final class ListAvailableDomainExtensionsResponseSingleEntry implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $tld,
        public readonly ?string $tldType,
        /** @var list<string>|null */
        public readonly ?array $categories,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            tld: Wire::string($raw, 'tld'),
            tldType: Wire::string($raw, 'tldType'),
            categories: Wire::strings($raw, 'categories'),
        );
    }
}
