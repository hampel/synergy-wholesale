<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "singleSSLPricingResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class SingleSSLPricingResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?int $productID,
        public readonly ?string $productName,
        public readonly ?string $productDescription,
        public readonly ?string $remoteProductType,
        public readonly ?string $price,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            productID: Wire::int($raw, 'productID'),
            productName: Wire::string($raw, 'productName'),
            productDescription: Wire::string($raw, 'productDescription'),
            remoteProductType: Wire::string($raw, 'remoteProductType'),
            price: Wire::string($raw, 'price'),
        );
    }
}
