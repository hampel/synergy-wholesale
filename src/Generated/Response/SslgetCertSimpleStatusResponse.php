<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "SSL_getCertSimpleStatusResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class SslgetCertSimpleStatusResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $certStatus,
        public readonly ?string $certID,
        public readonly ?string $commonName,
        public readonly ?string $customerID,
        public readonly ?string $startDate,
        public readonly ?string $expireDate,
        public readonly ?string $productName,
        public readonly ?string $productYears,
        public readonly ?string $productType,
        public readonly ?string $productID,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            certStatus: Wire::string($raw, 'certStatus'),
            certID: Wire::string($raw, 'certID'),
            commonName: Wire::string($raw, 'commonName'),
            customerID: Wire::string($raw, 'customerID'),
            startDate: Wire::string($raw, 'startDate'),
            expireDate: Wire::string($raw, 'expireDate'),
            productName: Wire::string($raw, 'productName'),
            productYears: Wire::string($raw, 'productYears'),
            productType: Wire::string($raw, 'productType'),
            productID: Wire::string($raw, 'productID'),
        );
    }
}
