<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "getDomainExtensionOptionsResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class GetDomainExtensionOptionsResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $canRenewWithin,
        public readonly ?string $cannotRenewAfter,
        public readonly ?string $cannotRestoreAfter,
        public readonly ?string $deletesAfter,
        public readonly ?string $isIPV4Capable,
        public readonly ?string $isIPV6Capable,
        public readonly ?string $isIDProtectCapable,
        public readonly ?string $transferLock,
        public readonly ?string $isHostsCapable,
        public readonly ?string $minYears,
        public readonly ?string $maxYears,
        public readonly ?string $canRenew,
        public readonly ?string $canRestore,
        public readonly ?bool $DNSSECAvailable,
        /** @var list<string>|null */
        public readonly ?array $availableContacts,
        public readonly ?bool $whoisVerification,
        public readonly ?PasswordRequirementsResponse $passwordRequirements,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            canRenewWithin: Wire::string($raw, 'canRenewWithin'),
            cannotRenewAfter: Wire::string($raw, 'cannotRenewAfter'),
            cannotRestoreAfter: Wire::string($raw, 'cannotRestoreAfter'),
            deletesAfter: Wire::string($raw, 'deletesAfter'),
            isIPV4Capable: Wire::string($raw, 'isIPV4Capable'),
            isIPV6Capable: Wire::string($raw, 'isIPV6Capable'),
            isIDProtectCapable: Wire::string($raw, 'isIDProtectCapable'),
            transferLock: Wire::string($raw, 'transferLock'),
            isHostsCapable: Wire::string($raw, 'isHostsCapable'),
            minYears: Wire::string($raw, 'minYears'),
            maxYears: Wire::string($raw, 'maxYears'),
            canRenew: Wire::string($raw, 'canRenew'),
            canRestore: Wire::string($raw, 'canRestore'),
            DNSSECAvailable: Wire::bool($raw, 'DNSSECAvailable'),
            availableContacts: Wire::strings($raw, 'availableContacts'),
            whoisVerification: Wire::bool($raw, 'whoisVerification'),
            passwordRequirements: Wire::object($raw, 'passwordRequirements', PasswordRequirementsResponse::class),
        );
    }
}
