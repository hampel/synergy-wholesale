<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Api;

use Hampel\SynergyWholesale\Client;
use Hampel\SynergyWholesale\Generated\Request\RawDomainInfoRequestSingle;
use Hampel\SynergyWholesale\Generated\Response\BalanceQueryResponse;
use Hampel\SynergyWholesale\Generated\Response\BulkCheckDomainResponse;
use Hampel\SynergyWholesale\Generated\Response\BulkDomainInfoResponse;
use Hampel\SynergyWholesale\Generated\Response\BulkRawDomainInfoResponse;
use Hampel\SynergyWholesale\Generated\Response\BusinessCheckRegistrationResponse;
use Hampel\SynergyWholesale\Generated\Response\CanRenewDomainResponse;
use Hampel\SynergyWholesale\Generated\Response\CancelChangeOfRegistrantResponse;
use Hampel\SynergyWholesale\Generated\Response\CancelRegistrantUpdateResponse;
use Hampel\SynergyWholesale\Generated\Response\CheckCorrectionResponse;
use Hampel\SynergyWholesale\Generated\Response\CheckDomainEPPCodeResponse;
use Hampel\SynergyWholesale\Generated\Response\CheckDomainResponse;
use Hampel\SynergyWholesale\Generated\Response\DeleteDomainResponse;
use Hampel\SynergyWholesale\Generated\Response\DisableAutoRenewalResponse;
use Hampel\SynergyWholesale\Generated\Response\DisableIDProtectionResponse;
use Hampel\SynergyWholesale\Generated\Response\DomainInfoResponse;
use Hampel\SynergyWholesale\Generated\Response\DomainRegisterResponse;
use Hampel\SynergyWholesale\Generated\Response\DomainReleaseUKResponse;
use Hampel\SynergyWholesale\Generated\Response\DomainRenewRequiredResponse;
use Hampel\SynergyWholesale\Generated\Response\EnableAutoRenewalResponse;
use Hampel\SynergyWholesale\Generated\Response\EnableIDProtectionResponse;
use Hampel\SynergyWholesale\Generated\Response\EnableRegistryLockResponse;
use Hampel\SynergyWholesale\Generated\Response\GenerateAuEligibilityResponse;
use Hampel\SynergyWholesale\Generated\Response\GetAuEntitlementsResponse;
use Hampel\SynergyWholesale\Generated\Response\GetDomainEligibilityFieldsResponse;
use Hampel\SynergyWholesale\Generated\Response\GetDomainExtensionOptionsResponse;
use Hampel\SynergyWholesale\Generated\Response\GetDomainPricingResponse;
use Hampel\SynergyWholesale\Generated\Response\GetSSLPricingResponse;
use Hampel\SynergyWholesale\Generated\Response\GetTransferredAwayDomainsResponse;
use Hampel\SynergyWholesale\Generated\Response\GetUSNexusDataResponse;
use Hampel\SynergyWholesale\Generated\Response\GetWHMCSModulesVersionsResponse;
use Hampel\SynergyWholesale\Generated\Response\InitiateAUCORResponse;
use Hampel\SynergyWholesale\Generated\Response\InitiateCorrectionResponse;
use Hampel\SynergyWholesale\Generated\Response\IsDomainTransferrableResponse;
use Hampel\SynergyWholesale\Generated\Response\ListAuNonCompliantDomainsResponse;
use Hampel\SynergyWholesale\Generated\Response\ListAvailableDomainExtensionsResponse;
use Hampel\SynergyWholesale\Generated\Response\ListContactsResponse;
use Hampel\SynergyWholesale\Generated\Response\ListPendingCORResponse;
use Hampel\SynergyWholesale\Generated\Response\LockDomainResponse;
use Hampel\SynergyWholesale\Generated\Response\MaxYearsCanRenewForResponse;
use Hampel\SynergyWholesale\Generated\Response\RawDomainContactsResponse;
use Hampel\SynergyWholesale\Generated\Response\RawDomainInfoResponse;
use Hampel\SynergyWholesale\Generated\Response\RenewDomainResponse;
use Hampel\SynergyWholesale\Generated\Response\ResendChangeOfRegistrantEmailsResponse;
use Hampel\SynergyWholesale\Generated\Response\ResendCorrectionEmailResponse;
use Hampel\SynergyWholesale\Generated\Response\ResendRegistrantUpdateEmailsResponse;
use Hampel\SynergyWholesale\Generated\Response\ResendTransferEmailResponse;
use Hampel\SynergyWholesale\Generated\Response\ResendVerificationEmailResponse;
use Hampel\SynergyWholesale\Generated\Response\RestoreDomainResponse;
use Hampel\SynergyWholesale\Generated\Response\TransferCancelResponse;
use Hampel\SynergyWholesale\Generated\Response\TransferDomainResponse;
use Hampel\SynergyWholesale\Generated\Response\TransferOutboundApproveResponse;
use Hampel\SynergyWholesale\Generated\Response\TransferRejectResponse;
use Hampel\SynergyWholesale\Generated\Response\UnlockDomainResponse;
use Hampel\SynergyWholesale\Generated\Response\UpdateContactResponse;
use Hampel\SynergyWholesale\Generated\Response\UpdateDomainPasswordResponse;
use Hampel\SynergyWholesale\Generated\Response\UpdateNameServersResponse;
use Hampel\SynergyWholesale\Value\Contact;

/**
 * Generated from the Synergy Wholesale WSDL.
 *
 * Do not edit: run `composer generate` instead.
 */
final class DomainsApi
{
    public function __construct(private readonly Client $client)
    {
    }

    /**
     * Will retrieve the entity details for the supplied business registration number
     *
     * SOAP operation: businessCheckRegistration
     */
    public function businessCheckRegistration(
        string $registrationNumber,
        ?string $registrationState = null,
    ): BusinessCheckRegistrationResponse {
        return BusinessCheckRegistrationResponse::fromWire($this->client->call('businessCheckRegistration', [
            'registrationNumber' => $registrationNumber,
            'registrationState' => $registrationState,
        ]));
    }

    /**
     * Will check to see what the resellers balance is
     *
     * SOAP operation: balanceQuery
     */
    public function balanceQuery(): BalanceQueryResponse
    {
        return BalanceQueryResponse::fromWire($this->client->call('balanceQuery', []));
    }

    /**
     * Will return a list of available domain extensions for a reseller
     *
     * SOAP operation: listAvailableDomainExtensions
     */
    public function listAvailableDomainExtensions(): ListAvailableDomainExtensionsResponse
    {
        return ListAvailableDomainExtensionsResponse::fromWire($this->client->call('listAvailableDomainExtensions', []));
    }

    /**
     * Returns the custom eligibility fields for the provided extension
     *
     * SOAP operation: getDomainEligibilityFields
     */
    public function getDomainEligibilityFields(
        string $extension,
    ): GetDomainEligibilityFieldsResponse {
        return GetDomainEligibilityFieldsResponse::fromWire($this->client->call('getDomainEligibilityFields', [
            'extension' => $extension,
        ]));
    }

    /**
     * Returns a completed or partially (depending on the identifier) completed .au eligibility criteria
     *
     * SOAP operation: generateAuEligibility
     */
    public function generateAuEligibility(
        string $registrationIdentifier,
        ?string $type = null,
    ): GenerateAuEligibilityResponse {
        return GenerateAuEligibilityResponse::fromWire($this->client->call('generateAuEligibility', [
            'registrationIdentifier' => $registrationIdentifier,
            'type' => $type,
        ]));
    }

    /**
     * Retrieve pricing for all of Synergy Wholesale TLDs
     *
     * SOAP operation: getDomainPricing
     */
    public function getDomainPricing(): GetDomainPricingResponse
    {
        return GetDomainPricingResponse::fromWire($this->client->call('getDomainPricing', []));
    }

    /**
     * Retrieve pricing for all of Synergy Wholesale SSL Certificates
     *
     * SOAP operation: getSSLPricing
     */
    public function getSSLPricing(): GetSSLPricingResponse
    {
        return GetSSLPricingResponse::fromWire($this->client->call('getSSLPricing', []));
    }

    /**
     * Restore a domain name from redemption
     *
     * SOAP operation: restoreDomain
     */
    public function restoreDomain(
        string $domainName,
        string $redemptionPrice,
        ?bool $premium = null,
    ): RestoreDomainResponse {
        return RestoreDomainResponse::fromWire($this->client->call('restoreDomain', [
            'domainName' => $domainName,
            'redemptionPrice' => $redemptionPrice,
            'premium' => $premium,
        ]));
    }

    /**
     * Will resend the ICANN Whois Verification Email for the specified domain name
     *
     * SOAP operation: resendVerificationEmail
     */
    public function resendVerificationEmail(
        string $domainName,
    ): ResendVerificationEmailResponse {
        return ResendVerificationEmailResponse::fromWire($this->client->call('resendVerificationEmail', [
            'domainName' => $domainName,
        ]));
    }

    /**
     * Will get the number of years maximum that the domain in question can be renewed for
     *
     * SOAP operation: maxYearsCanRenewFor
     */
    public function maxYearsCanRenewFor(
        string $domainName,
        ?string $associationID = null,
    ): MaxYearsCanRenewForResponse {
        return MaxYearsCanRenewForResponse::fromWire($this->client->call('maxYearsCanRenewFor', [
            'domainName' => $domainName,
            'associationID' => $associationID,
        ]));
    }

    /**
     * Will retrieve the us nexus data for the specified domain name
     *
     * SOAP operation: getUSNexusData
     */
    public function getUSNexusData(
        string $domainName,
    ): GetUSNexusDataResponse {
        return GetUSNexusDataResponse::fromWire($this->client->call('getUSNexusData', [
            'domainName' => $domainName,
        ]));
    }

    /**
     * Will return the specific extension options for the tld requested
     *
     * SOAP operation: getDomainExtensionOptions
     */
    public function getDomainExtensionOptions(
        string $tld,
    ): GetDomainExtensionOptionsResponse {
        return GetDomainExtensionOptionsResponse::fromWire($this->client->call('getDomainExtensionOptions', [
            'tld' => $tld,
        ]));
    }

    /**
     * Check multiple domains to see if they can be registered
     *
     * @param list<string> $domainList
     *
     * SOAP operation: bulkCheckDomain
     */
    public function bulkCheckDomain(
        array $domainList,
        ?int $years = null,
        ?string $command = null,
    ): BulkCheckDomainResponse {
        return BulkCheckDomainResponse::fromWire($this->client->call('bulkCheckDomain', [
            'domainList' => $domainList,
            'years' => $years,
            'command' => $command,
        ]));
    }

    /**
     * Will check to see if a specific domain is available to register
     *
     * SOAP operation: checkDomain
     */
    public function checkDomain(
        string $domainName,
        ?int $years = null,
        ?string $command = null,
    ): CheckDomainResponse {
        return CheckDomainResponse::fromWire($this->client->call('checkDomain', [
            'domainName' => $domainName,
            'years' => $years,
            'command' => $command,
        ]));
    }

    /**
     * Will get details of the specified domain if it exists
     *
     * SOAP operation: domainInfo
     */
    public function domainInfo(
        string $domainName,
        ?string $associationID = null,
    ): DomainInfoResponse {
        return DomainInfoResponse::fromWire($this->client->call('domainInfo', [
            'domainName' => $domainName,
            'associationID' => $associationID,
        ]));
    }

    /**
     * Will get the details of a list of provided domains if it exists
     *
     * @param list<string> $domainList
     *
     * SOAP operation: bulkDomainInfo
     */
    public function bulkDomainInfo(
        array $domainList,
    ): BulkDomainInfoResponse {
        return BulkDomainInfoResponse::fromWire($this->client->call('bulkDomainInfo', [
            'domainList' => $domainList,
        ]));
    }

    /**
     * Will get the details of a list of provided domains if it exists
     *
     * SOAP operation: listDomains
     */
    public function listDomains(
        ?int $page = null,
        ?int $limit = null,
        ?string $status = null,
    ): BulkDomainInfoResponse {
        return BulkDomainInfoResponse::fromWire($this->client->call('listDomains', [
            'page' => $page,
            'limit' => $limit,
            'status' => $status,
        ]));
    }

    /**
     * Will register a domain name
     *
     * @param list<string>|null $nameServers
     * @param list<string>|null $categories
     *
     * SOAP operation: domainRegister
     */
    public function domainRegister(
        string $domainName,
        string $years,
        Contact $registrant,
        ?array $nameServers = null,
        ?string $idProtect = null,
        ?bool $specialConditionsAgree = null,
        ?bool $autoRenew = null,
        ?bool $premium = null,
        ?string $costPrice = null,
        ?string $eligibility = null,
        ?bool $transferLock = null,
        ?array $categories = null,
        ?int $dnsConfig = null,
        ?bool $skipEmail = null,
        ?Contact $technical = null,
        ?Contact $admin = null,
        ?Contact $billing = null,
    ): DomainRegisterResponse {
        return DomainRegisterResponse::fromWire($this->client->call('domainRegister', [
            'domainName' => $domainName,
            'years' => $years,
            ...Contact::wire('registrant', $registrant),
            'nameServers' => $nameServers,
            'idProtect' => $idProtect,
            'specialConditionsAgree' => $specialConditionsAgree,
            'autoRenew' => $autoRenew,
            'premium' => $premium,
            'costPrice' => $costPrice,
            'eligibility' => $eligibility,
            'transferLock' => $transferLock,
            'categories' => $categories,
            'dnsConfig' => $dnsConfig,
            'skipEmail' => $skipEmail,
            ...Contact::wire('technical', $technical),
            ...Contact::wire('admin', $admin),
            ...Contact::wire('billing', $billing),
        ]));
    }

    /**
     * Will resend the transfer confirmation email
     *
     * SOAP operation: resendTransferEmail
     */
    public function resendTransferEmail(
        string $domainName,
    ): ResendTransferEmailResponse {
        return ResendTransferEmailResponse::fromWire($this->client->call('resendTransferEmail', [
            'domainName' => $domainName,
        ]));
    }

    /**
     * Will Check To See If Domain Transfer Requires Renewal
     *
     * SOAP operation: domainRenewRequired
     */
    public function domainRenewRequired(
        string $domainName,
        string $authInfo,
    ): DomainRenewRequiredResponse {
        return DomainRenewRequiredResponse::fromWire($this->client->call('domainRenewRequired', [
            'domainName' => $domainName,
            'authInfo' => $authInfo,
        ]));
    }

    /**
     * Will transfer the specified domain
     *
     * @param list<string>|null $nameServers
     * @param list<string>|null $categories
     *
     * SOAP operation: transferDomain
     */
    public function transferDomain(
        string $domainName,
        string $authInfo,
        Contact $contact,
        ?string $doRenewal = null,
        ?string $idProtect = null,
        ?bool $autoRenew = null,
        ?int $renewYears = null,
        ?string $costPrice = null,
        ?bool $premium = null,
        ?string $eligibility = null,
        ?bool $transferLock = null,
        ?array $nameServers = null,
        ?array $categories = null,
        ?int $dnsConfig = null,
    ): TransferDomainResponse {
        return TransferDomainResponse::fromWire($this->client->call('transferDomain', [
            'domainName' => $domainName,
            'authInfo' => $authInfo,
            ...Contact::wire('', $contact),
            'doRenewal' => $doRenewal,
            'idProtect' => $idProtect,
            'autoRenew' => $autoRenew,
            'renewYears' => $renewYears,
            'costPrice' => $costPrice,
            'premium' => $premium,
            'eligibility' => $eligibility,
            'transferLock' => $transferLock,
            'nameServers' => $nameServers,
            'categories' => $categories,
            'dnsConfig' => $dnsConfig,
        ]));
    }

    /**
     * Will Update Domain Password With New One Specified
     *
     * SOAP operation: updateDomainPassword
     */
    public function updateDomainPassword(
        string $domainName,
        ?string $newPassword = null,
    ): UpdateDomainPasswordResponse {
        return UpdateDomainPasswordResponse::fromWire($this->client->call('updateDomainPassword', [
            'domainName' => $domainName,
            'newPassword' => $newPassword,
        ]));
    }

    /**
     * Will Update Domain Name Servers With New Ones Specified
     *
     * @param list<string> $nameServers
     *
     * SOAP operation: updateNameServers
     */
    public function updateNameServers(
        string $domainName,
        array $nameServers,
        ?int $dnsConfigType = null,
        ?int $dnsConfig = null,
    ): UpdateNameServersResponse {
        return UpdateNameServersResponse::fromWire($this->client->call('updateNameServers', [
            'domainName' => $domainName,
            'nameServers' => $nameServers,
            'dnsConfigType' => $dnsConfigType,
            'dnsConfig' => $dnsConfig,
        ]));
    }

    /**
     * Will lock the specified domain name
     *
     * SOAP operation: lockDomain
     */
    public function lockDomain(
        string $domainName,
    ): LockDomainResponse {
        return LockDomainResponse::fromWire($this->client->call('lockDomain', [
            'domainName' => $domainName,
        ]));
    }

    /**
     * Will unlock the specified domain name
     *
     * SOAP operation: unlockDomain
     */
    public function unlockDomain(
        string $domainName,
    ): UnlockDomainResponse {
        return UnlockDomainResponse::fromWire($this->client->call('unlockDomain', [
            'domainName' => $domainName,
        ]));
    }

    /**
     * Will renew the specified domain name
     *
     * SOAP operation: renewDomain
     */
    public function renewDomain(
        string $domainName,
        int $years,
        ?string $costPrice = null,
        ?bool $premium = null,
        ?string $associationID = null,
    ): RenewDomainResponse {
        return RenewDomainResponse::fromWire($this->client->call('renewDomain', [
            'domainName' => $domainName,
            'years' => $years,
            'costPrice' => $costPrice,
            'premium' => $premium,
            'associationID' => $associationID,
        ]));
    }

    /**
     * Will release a specific domain name from Nominet
     *
     * SOAP operation: domainReleaseUK
     */
    public function domainReleaseUK(
        string $domainName,
        string $tagName,
        ?int $newResellerID = null,
    ): DomainReleaseUKResponse {
        return DomainReleaseUKResponse::fromWire($this->client->call('domainReleaseUK', [
            'domainName' => $domainName,
            'tagName' => $tagName,
            'newResellerID' => $newResellerID,
        ]));
    }

    /**
     * Will list domains that have transferred out from your reseller account
     *
     * SOAP operation: getTransferredAwayDomains
     */
    public function getTransferredAwayDomains(
        ?string $startDate = null,
        ?string $endDate = null,
    ): GetTransferredAwayDomainsResponse {
        return GetTransferredAwayDomainsResponse::fromWire($this->client->call('getTransferredAwayDomains', [
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]));
    }

    /**
     * Will submit a cor to the system
     *
     * SOAP operation: initiateAUCOR
     */
    public function initiateAUCOR(
        string $domainName,
        ?int $years = null,
    ): InitiateAUCORResponse {
        return InitiateAUCORResponse::fromWire($this->client->call('initiateAUCOR', [
            'domainName' => $domainName,
            'years' => $years,
        ]));
    }

    /**
     * This function will activate automatic renewal on the specified domain
     *
     * SOAP operation: enableAutoRenewal
     */
    public function enableAutoRenewal(
        string $domainName,
        ?string $associationID = null,
    ): EnableAutoRenewalResponse {
        return EnableAutoRenewalResponse::fromWire($this->client->call('enableAutoRenewal', [
            'domainName' => $domainName,
            'associationID' => $associationID,
        ]));
    }

    /**
     * This function will deactivate automatic renewal on the specified domain
     *
     * SOAP operation: disableAutoRenewal
     */
    public function disableAutoRenewal(
        string $domainName,
        ?string $associationID = null,
    ): DisableAutoRenewalResponse {
        return DisableAutoRenewalResponse::fromWire($this->client->call('disableAutoRenewal', [
            'domainName' => $domainName,
            'associationID' => $associationID,
        ]));
    }

    /**
     * This function will see if a domain can be renewed yet and if it can, will return the maximum number of years possible to renew the domain for
     *
     * SOAP operation: canRenewDomain
     */
    public function canRenewDomain(
        string $domainName,
        ?string $associationID = null,
    ): CanRenewDomainResponse {
        return CanRenewDomainResponse::fromWire($this->client->call('canRenewDomain', [
            'domainName' => $domainName,
            'associationID' => $associationID,
        ]));
    }

    /**
     * This function will confirm if the supplied epp password is correct at the registry
     *
     * SOAP operation: checkDomainEPPCode
     */
    public function checkDomainEPPCode(
        string $domainName,
        string $authInfo,
    ): CheckDomainEPPCodeResponse {
        return CheckDomainEPPCodeResponse::fromWire($this->client->call('checkDomainEPPCode', [
            'domainName' => $domainName,
            'authInfo' => $authInfo,
        ]));
    }

    /**
     * This function will return raw contact information from the registry
     *
     * SOAP operation: rawDomainContacts
     */
    public function rawDomainContacts(
        string $domainName,
        string $authInfo,
    ): RawDomainContactsResponse {
        return RawDomainContactsResponse::fromWire($this->client->call('rawDomainContacts', [
            'domainName' => $domainName,
            'authInfo' => $authInfo,
        ]));
    }

    /**
     * This function will return raw information from the registry
     *
     * SOAP operation: rawDomainInfo
     */
    public function rawDomainInfo(
        string $domainName,
        string $authInfo,
    ): RawDomainInfoResponse {
        return RawDomainInfoResponse::fromWire($this->client->call('rawDomainInfo', [
            'domainName' => $domainName,
            'authInfo' => $authInfo,
        ]));
    }

    /**
     * This function will see if a domain can be transferred
     *
     * SOAP operation: isDomainTransferrable
     */
    public function isDomainTransferrable(
        string $domainName,
        string $authInfo,
    ): IsDomainTransferrableResponse {
        return IsDomainTransferrableResponse::fromWire($this->client->call('isDomainTransferrable', [
            'domainName' => $domainName,
            'authInfo' => $authInfo,
        ]));
    }

    /**
     * This function will update a contact in the system
     *
     * SOAP operation: updateContact
     */
    public function updateContact(
        string $domainName,
        string $appPurpose,
        string $nexusCategory,
        Contact $registrant,
        ?bool $nz_privacy = null,
        ?Contact $technical = null,
        ?Contact $admin = null,
        ?Contact $billing = null,
    ): UpdateContactResponse {
        return UpdateContactResponse::fromWire($this->client->call('updateContact', [
            'domainName' => $domainName,
            'appPurpose' => $appPurpose,
            'nexusCategory' => $nexusCategory,
            ...Contact::wire('registrant', $registrant),
            'nz_privacy' => $nz_privacy,
            ...Contact::wire('technical', $technical),
            ...Contact::wire('admin', $admin),
            ...Contact::wire('billing', $billing),
        ]));
    }

    /**
     * This function will list the contacts for the specified domain name
     *
     * SOAP operation: listContacts
     */
    public function listContacts(
        string $domainName,
    ): ListContactsResponse {
        return ListContactsResponse::fromWire($this->client->call('listContacts', [
            'domainName' => $domainName,
        ]));
    }

    /**
     * This function will list the contacts behind ID Protection for the specified domain name
     *
     * SOAP operation: listProtectedContacts
     */
    public function listProtectedContacts(
        string $domainName,
    ): ListContactsResponse {
        return ListContactsResponse::fromWire($this->client->call('listProtectedContacts', [
            'domainName' => $domainName,
        ]));
    }

    /**
     * This function will enable id protection on the specified domain name
     *
     * SOAP operation: enableIDProtection
     */
    public function enableIDProtection(
        string $domainName,
    ): EnableIDProtectionResponse {
        return EnableIDProtectionResponse::fromWire($this->client->call('enableIDProtection', [
            'domainName' => $domainName,
        ]));
    }

    /**
     * This function will disable id protection on the specified domain name
     *
     * SOAP operation: disableIDProtection
     */
    public function disableIDProtection(
        string $domainName,
    ): DisableIDProtectionResponse {
        return DisableIDProtectionResponse::fromWire($this->client->call('disableIDProtection', [
            'domainName' => $domainName,
        ]));
    }

    /**
     * Get current list of whmcs modules supported by Synergy Wholesale
     *
     * SOAP operation: getWHMCSModulesVersions
     */
    public function getWHMCSModulesVersions(): GetWHMCSModulesVersionsResponse
    {
        return GetWHMCSModulesVersionsResponse::fromWire($this->client->call('getWHMCSModulesVersions', []));
    }

    /**
     * Resends the Registrant Update emails to users that are yet to approve the changes
     *
     * SOAP operation: resendRegistrantUpdateEmails
     */
    public function resendRegistrantUpdateEmails(
        string $domainName,
    ): ResendRegistrantUpdateEmailsResponse {
        return ResendRegistrantUpdateEmailsResponse::fromWire($this->client->call('resendRegistrantUpdateEmails', [
            'domainName' => $domainName,
        ]));
    }

    /**
     * Cancels a pending registrant update
     *
     * SOAP operation: cancelRegistrantUpdate
     */
    public function cancelRegistrantUpdate(
        string $domainName,
    ): CancelRegistrantUpdateResponse {
        return CancelRegistrantUpdateResponse::fromWire($this->client->call('cancelRegistrantUpdate', [
            'domainName' => $domainName,
        ]));
    }

    /**
     * Approves the outbound transfer of a domain name
     *
     * SOAP operation: transferOutboundApprove
     */
    public function transferOutboundApprove(
        string $domainName,
    ): TransferOutboundApproveResponse {
        return TransferOutboundApproveResponse::fromWire($this->client->call('transferOutboundApprove', [
            'domainName' => $domainName,
        ]));
    }

    /**
     * Rejects the outbound transfer of a domain name
     *
     * SOAP operation: transferReject
     */
    public function transferReject(
        string $domainName,
        string $reason,
    ): TransferRejectResponse {
        return TransferRejectResponse::fromWire($this->client->call('transferReject', [
            'domainName' => $domainName,
            'reason' => $reason,
        ]));
    }

    /**
     * This function cancels the pending COR request
     *
     * SOAP operation: cancelChangeOfRegistrant
     */
    public function cancelChangeOfRegistrant(
        string $domainName,
    ): CancelChangeOfRegistrantResponse {
        return CancelChangeOfRegistrantResponse::fromWire($this->client->call('cancelChangeOfRegistrant', [
            'domainName' => $domainName,
        ]));
    }

    /**
     * Will resend the Change of Registrant Email
     *
     * SOAP operation: resendChangeOfRegistrantEmails
     */
    public function resendChangeOfRegistrantEmails(
        string $domainName,
    ): ResendChangeOfRegistrantEmailsResponse {
        return ResendChangeOfRegistrantEmailsResponse::fromWire($this->client->call('resendChangeOfRegistrantEmails', [
            'domainName' => $domainName,
        ]));
    }

    /**
     * Will cancel an inbound domain transfer
     *
     * SOAP operation: transferCancel
     */
    public function transferCancel(
        string $domainName,
    ): TransferCancelResponse {
        return TransferCancelResponse::fromWire($this->client->call('transferCancel', [
            'domainName' => $domainName,
        ]));
    }

    /**
     * Will Return Au Direct entitlements
     *
     * SOAP operation: getAuEntitlements
     */
    public function getAuEntitlements(
        string $label,
    ): GetAuEntitlementsResponse {
        return GetAuEntitlementsResponse::fromWire($this->client->call('getAuEntitlements', [
            'label' => $label,
        ]));
    }

    /**
     * This function deletes the domain
     *
     * SOAP operation: deleteDomain
     */
    public function deleteDomain(
        string $domainName,
        string $reason,
        bool $confirm,
    ): DeleteDomainResponse {
        return DeleteDomainResponse::fromWire($this->client->call('deleteDomain', [
            'domainName' => $domainName,
            'reason' => $reason,
            'confirm' => $confirm,
        ]));
    }

    /**
     * This function returns a list of all pending CORs of the domains which belong to the reseller account
     *
     * SOAP operation: listPendingCOR
     */
    public function listPendingCOR(): ListPendingCORResponse
    {
        return ListPendingCORResponse::fromWire($this->client->call('listPendingCOR', []));
    }

    /**
     * This function returns a list of all au domains with invalid eligibility criteria which belong to the reseller account
     *
     * SOAP operation: listAuNonCompliantDomains
     */
    public function listAuNonCompliantDomains(): ListAuNonCompliantDomainsResponse
    {
        return ListAuNonCompliantDomainsResponse::fromWire($this->client->call('listAuNonCompliantDomains', []));
    }

    /**
     * This function will attempt to initiate the registry lock process on a given domain
     *
     * SOAP operation: enableRegistryLock
     */
    public function enableRegistryLock(
        string $domainName,
    ): EnableRegistryLockResponse {
        return EnableRegistryLockResponse::fromWire($this->client->call('enableRegistryLock', [
            'domainName' => $domainName,
        ]));
    }

    /**
     * This function returns details of a pending domain registrant correction
     *
     * SOAP operation: checkCorrection
     */
    public function checkCorrection(
        string $domainName,
    ): CheckCorrectionResponse {
        return CheckCorrectionResponse::fromWire($this->client->call('checkCorrection', [
            'domainName' => $domainName,
        ]));
    }

    /**
     * This function will attempt to initiate the domain registrant correction
     *
     * SOAP operation: initiateCorrection
     */
    public function initiateCorrection(
        string $domainName,
    ): InitiateCorrectionResponse {
        return InitiateCorrectionResponse::fromWire($this->client->call('initiateCorrection', [
            'domainName' => $domainName,
        ]));
    }

    /**
     * This function will attempt to resend domain registrant correction email
     *
     * SOAP operation: resendCorrectionEmail
     */
    public function resendCorrectionEmail(
        string $domainName,
    ): ResendCorrectionEmailResponse {
        return ResendCorrectionEmailResponse::fromWire($this->client->call('resendCorrectionEmail', [
            'domainName' => $domainName,
        ]));
    }

    /**
     * Fetch the raw domain info for multiple domain names.
     *
     * @param list<RawDomainInfoRequestSingle> $domainList
     *
     * SOAP operation: bulkRawDomainInfo
     */
    public function bulkRawDomainInfo(
        array $domainList,
    ): BulkRawDomainInfoResponse {
        return BulkRawDomainInfoResponse::fromWire($this->client->call('bulkRawDomainInfo', [
            'domainList' => array_map(static fn (RawDomainInfoRequestSingle $e): array => $e->toWire(), $domainList),
        ]));
    }
}
