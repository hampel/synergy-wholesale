<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "SSL_checkTxtCodesResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class SslcheckTxtCodesResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $validationStatus,
        public readonly ?SslcheckTxtCodesResponseArray $domains,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            validationStatus: Wire::string($raw, 'validationStatus'),
            domains: Wire::object($raw, 'domains', SslcheckTxtCodesResponseArray::class),
        );
    }
}
