<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "SSL_reissueCertificateResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class SslreissueCertificateResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $newCertID,
        public readonly ?string $cer,
        public readonly ?string $p7b,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            newCertID: Wire::string($raw, 'newCertID'),
            cer: Wire::string($raw, 'cer'),
            p7b: Wire::string($raw, 'p7b'),
        );
    }
}
