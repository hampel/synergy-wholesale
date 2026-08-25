<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "SSL_listAllCertsResponseSingleEntry".
 *
 * Do not edit: run `composer generate` instead.
 */
final class SsllistAllCertsResponseSingleEntry implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $certID,
        public readonly ?string $productID,
        public readonly ?string $csr,
        public readonly ?string $cer,
        public readonly ?string $p7b,
        public readonly ?string $commonName,
        public readonly ?string $startDate,
        public readonly ?string $expireDate,
        public readonly ?string $orderDate,
        public readonly ?string $newCertID,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            certID: Wire::string($raw, 'certID'),
            productID: Wire::string($raw, 'productID'),
            csr: Wire::string($raw, 'csr'),
            cer: Wire::string($raw, 'cer'),
            p7b: Wire::string($raw, 'p7b'),
            commonName: Wire::string($raw, 'commonName'),
            startDate: Wire::string($raw, 'startDate'),
            expireDate: Wire::string($raw, 'expireDate'),
            orderDate: Wire::string($raw, 'orderDate'),
            newCertID: Wire::string($raw, 'newCertID'),
        );
    }
}
