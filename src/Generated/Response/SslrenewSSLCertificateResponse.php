<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "SSL_renewSSLCertificateResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class SslrenewSSLCertificateResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $certStatus,
        public readonly ?string $certID,
        public readonly ?string $commonName,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            certStatus: Wire::string($raw, 'certStatus'),
            certID: Wire::string($raw, 'certID'),
            commonName: Wire::string($raw, 'commonName'),
        );
    }
}
