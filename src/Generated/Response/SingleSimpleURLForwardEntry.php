<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "singleSimpleURLForwardEntry".
 *
 * Do not edit: run `composer generate` instead.
 */
final class SingleSimpleURLForwardEntry implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $recordID,
        public readonly ?string $hostname,
        public readonly ?string $destination,
        public readonly ?string $redirectType,
        public readonly ?string $pageTitle,
        public readonly ?string $metaKeywords,
        public readonly ?string $metaDescription,
        public readonly ?string $refreshSeconds,
        public readonly ?string $h1Title,
        public readonly ?string $redirectMessage,
        public readonly ?string $redirectStructure,
        public readonly ?bool $retainPath,
        public readonly ?bool $wildcardSource,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            recordID: Wire::string($raw, 'recordID'),
            hostname: Wire::string($raw, 'hostname'),
            destination: Wire::string($raw, 'destination'),
            redirectType: Wire::string($raw, 'redirectType'),
            pageTitle: Wire::string($raw, 'pageTitle'),
            metaKeywords: Wire::string($raw, 'metaKeywords'),
            metaDescription: Wire::string($raw, 'metaDescription'),
            refreshSeconds: Wire::string($raw, 'refreshSeconds'),
            h1Title: Wire::string($raw, 'h1Title'),
            redirectMessage: Wire::string($raw, 'redirectMessage'),
            redirectStructure: Wire::string($raw, 'redirectStructure'),
            retainPath: Wire::bool($raw, 'retainPath'),
            wildcardSource: Wire::bool($raw, 'wildcardSource'),
        );
    }
}
