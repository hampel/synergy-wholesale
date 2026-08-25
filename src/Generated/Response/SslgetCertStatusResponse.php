<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "SSL_getCertStatusResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class SslgetCertStatusResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $commonName,
        public readonly ?bool $reviewed,
        public readonly ?bool $domainValid,
        public readonly ?bool $orgValid,
        public readonly ?bool $issued,
        public readonly ?string $startDate,
        public readonly ?string $expireDate,
        public readonly ?bool $isRefunded,
        public readonly ?bool $isCancelled,
        public readonly ?bool $isRevoked,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            commonName: Wire::string($raw, 'commonName'),
            reviewed: Wire::bool($raw, 'reviewed'),
            domainValid: Wire::bool($raw, 'domainValid'),
            orgValid: Wire::bool($raw, 'orgValid'),
            issued: Wire::bool($raw, 'issued'),
            startDate: Wire::string($raw, 'startDate'),
            expireDate: Wire::string($raw, 'expireDate'),
            isRefunded: Wire::bool($raw, 'isRefunded'),
            isCancelled: Wire::bool($raw, 'isCancelled'),
            isRevoked: Wire::bool($raw, 'isRevoked'),
        );
    }
}
