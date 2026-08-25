<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "bulkDomainInfoResponseSingleEntry".
 *
 * Do not edit: run `composer generate` instead.
 */
final class BulkDomainInfoResponseSingleEntry implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $domainName,
        public readonly ?string $domainRoid,
        public readonly ?string $transfer_status,
        public readonly ?string $transfer_completed_by,
        public readonly ?string $domain_status,
        public readonly ?string $domain_expiry,
        /** @var list<string>|null */
        public readonly ?array $nameServers,
        public readonly ?string $email,
        public readonly ?int $dnsConfig,
        public readonly ?string $dnsConfigName,
        public readonly ?int $bulkInProgress,
        public readonly ?string $domainPassword,
        public readonly ?string $idProtect,
        public readonly ?int $autoRenew,
        /** @var list<DomainCategorySingleEntry>|null */
        public readonly ?array $categories,
        public readonly ?string $registryID,
        public readonly ?string $icannVerificationDateEnd,
        public readonly ?string $icannStatus,
        public readonly ?string $auRegistrantName,
        public readonly ?string $auRegistrantIDType,
        public readonly ?string $auRegistrantID,
        public readonly ?string $auEligibilityName,
        public readonly ?string $auEligibilityID,
        public readonly ?string $auEligibilityType,
        public readonly ?string $auEligibilityIDType,
        public readonly ?string $auEligibilityAssociationID,
        public readonly ?string $auEligibilityAssociationAuthInfo,
        public readonly ?string $auAssociationID,
        public readonly ?string $auAssociationAuthInfo,
        public readonly ?string $auPolicyID,
        public readonly ?string $auPolicyIDDesc,
        /** @var list<SingleDNSSECDSData>|null */
        public readonly ?array $DSData,
        public readonly ?string $canProcessRedemptionUntil,
        public readonly ?BulkDomainInfoContactsResponseArray $contacts,
        public readonly ?string $createdDate,
        public readonly ?string $pendingId,
        public readonly ?bool $au_valid_eligibility,
        public readonly ?string $au_eligibility_last_check,
        public readonly ?bool $auValidEligibility,
        public readonly ?string $auEligibilityLastCheck,
        public readonly ?string $auComplianceReason,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            domainName: Wire::string($raw, 'domainName'),
            domainRoid: Wire::string($raw, 'domainRoid'),
            transfer_status: Wire::string($raw, 'transfer_status'),
            transfer_completed_by: Wire::string($raw, 'transfer_completed_by'),
            domain_status: Wire::string($raw, 'domain_status'),
            domain_expiry: Wire::string($raw, 'domain_expiry'),
            nameServers: Wire::strings($raw, 'nameServers'),
            email: Wire::string($raw, 'email'),
            dnsConfig: Wire::int($raw, 'dnsConfig'),
            dnsConfigName: Wire::string($raw, 'dnsConfigName'),
            bulkInProgress: Wire::int($raw, 'bulkInProgress'),
            domainPassword: Wire::string($raw, 'domainPassword'),
            idProtect: Wire::string($raw, 'idProtect'),
            autoRenew: Wire::int($raw, 'autoRenew'),
            categories: Wire::objects($raw, 'categories', DomainCategorySingleEntry::class),
            registryID: Wire::string($raw, 'registryID'),
            icannVerificationDateEnd: Wire::string($raw, 'icannVerificationDateEnd'),
            icannStatus: Wire::string($raw, 'icannStatus'),
            auRegistrantName: Wire::string($raw, 'auRegistrantName'),
            auRegistrantIDType: Wire::string($raw, 'auRegistrantIDType'),
            auRegistrantID: Wire::string($raw, 'auRegistrantID'),
            auEligibilityName: Wire::string($raw, 'auEligibilityName'),
            auEligibilityID: Wire::string($raw, 'auEligibilityID'),
            auEligibilityType: Wire::string($raw, 'auEligibilityType'),
            auEligibilityIDType: Wire::string($raw, 'auEligibilityIDType'),
            auEligibilityAssociationID: Wire::string($raw, 'auEligibilityAssociationID'),
            auEligibilityAssociationAuthInfo: Wire::string($raw, 'auEligibilityAssociationAuthInfo'),
            auAssociationID: Wire::string($raw, 'auAssociationID'),
            auAssociationAuthInfo: Wire::string($raw, 'auAssociationAuthInfo'),
            auPolicyID: Wire::string($raw, 'auPolicyID'),
            auPolicyIDDesc: Wire::string($raw, 'auPolicyIDDesc'),
            DSData: Wire::objects($raw, 'DSData', SingleDNSSECDSData::class),
            canProcessRedemptionUntil: Wire::string($raw, 'canProcessRedemptionUntil'),
            contacts: Wire::object($raw, 'contacts', BulkDomainInfoContactsResponseArray::class),
            createdDate: Wire::string($raw, 'createdDate'),
            pendingId: Wire::string($raw, 'pendingId'),
            au_valid_eligibility: Wire::bool($raw, 'au_valid_eligibility'),
            au_eligibility_last_check: Wire::string($raw, 'au_eligibility_last_check'),
            auValidEligibility: Wire::bool($raw, 'auValidEligibility'),
            auEligibilityLastCheck: Wire::string($raw, 'auEligibilityLastCheck'),
            auComplianceReason: Wire::string($raw, 'auComplianceReason'),
        );
    }
}
