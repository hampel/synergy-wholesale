<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "getDNSRecordResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class GetDNSRecordResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $domainName,
        public readonly ?string $recordType,
        public readonly ?string $recordContent,
        public readonly ?int $recordTTL,
        public readonly ?int $recordPrio,
        public readonly ?string $recordID,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            domainName: Wire::string($raw, 'domainName'),
            recordType: Wire::string($raw, 'recordType'),
            recordContent: Wire::string($raw, 'recordContent'),
            recordTTL: Wire::int($raw, 'recordTTL'),
            recordPrio: Wire::int($raw, 'recordPrio'),
            recordID: Wire::string($raw, 'recordID'),
        );
    }
}
