<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "addDNSRecordResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class AddDNSRecordResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $id,
        public readonly ?string $domainName,
        public readonly ?string $recordName,
        public readonly ?string $recordType,
        public readonly ?string $recordContent,
        public readonly ?int $recordTTL,
        public readonly ?int $recordPrio,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            id: Wire::string($raw, 'id'),
            domainName: Wire::string($raw, 'domainName'),
            recordName: Wire::string($raw, 'recordName'),
            recordType: Wire::string($raw, 'recordType'),
            recordContent: Wire::string($raw, 'recordContent'),
            recordTTL: Wire::int($raw, 'recordTTL'),
            recordPrio: Wire::int($raw, 'recordPrio'),
        );
    }
}
