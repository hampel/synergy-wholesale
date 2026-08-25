<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "SSL_getSSLCertificateResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class SslgetSSLCertificateResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $certStatus,
        public readonly ?string $cer,
        public readonly ?string $p7b,
        public readonly ?string $certID,
        public readonly ?string $commonName,
        public readonly ?string $expireDate,
        public readonly ?string $caBundle,
        public readonly ?string $type,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            certStatus: Wire::string($raw, 'certStatus'),
            cer: Wire::string($raw, 'cer'),
            p7b: Wire::string($raw, 'p7b'),
            certID: Wire::string($raw, 'certID'),
            commonName: Wire::string($raw, 'commonName'),
            expireDate: Wire::string($raw, 'expireDate'),
            caBundle: Wire::string($raw, 'caBundle'),
            type: Wire::string($raw, 'type'),
        );
    }
}
