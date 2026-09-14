<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "SSL_checkTxtCodesResponseArray".
 *
 * Do not edit: run `composer generate` instead.
 */
final class SslcheckTxtCodesResponseArray implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $domain,
        public readonly ?string $status,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            domain: Wire::string($raw, 'domain'),
            status: Wire::string($raw, 'status'),
        );
    }
}
