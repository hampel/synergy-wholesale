<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "SSL_listAllCertsResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class SsllistAllCertsResponse implements HydratesFromWire
{
    public function __construct(
        /** @var list<SsllistAllCertsResponseSingleEntry>|null */
        public readonly ?array $certs,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            certs: Wire::objects($raw, 'certs', SsllistAllCertsResponseSingleEntry::class),
        );
    }
}
