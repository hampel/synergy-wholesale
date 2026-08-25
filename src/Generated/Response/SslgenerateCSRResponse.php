<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "SSL_generateCSRResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class SslgenerateCSRResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $privKey,
        public readonly ?string $selfSignCrt,
        public readonly ?string $csr,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            privKey: Wire::string($raw, 'privKey'),
            selfSignCrt: Wire::string($raw, 'selfSignCrt'),
            csr: Wire::string($raw, 'csr'),
        );
    }
}
