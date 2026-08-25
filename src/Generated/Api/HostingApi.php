<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Api;

use Hampel\SynergyWholesale\Client;
use Hampel\SynergyWholesale\Generated\Response\HostingChangePackageResponse;
use Hampel\SynergyWholesale\Generated\Response\HostingChangePasswordResponse;
use Hampel\SynergyWholesale\Generated\Response\HostingCheckFirewallResponse;
use Hampel\SynergyWholesale\Generated\Response\HostingEnableTempUrlResponse;
use Hampel\SynergyWholesale\Generated\Response\HostingGetLoginResponse;
use Hampel\SynergyWholesale\Generated\Response\HostingGetServiceResponse;
use Hampel\SynergyWholesale\Generated\Response\HostingListPackagesResponse;
use Hampel\SynergyWholesale\Generated\Response\HostingPurchaseServiceResponse;
use Hampel\SynergyWholesale\Generated\Response\HostingRecreateServiceResponse;
use Hampel\SynergyWholesale\Generated\Response\HostingSuspendServiceResponse;
use Hampel\SynergyWholesale\Generated\Response\HostingTerminateServiceResponse;
use Hampel\SynergyWholesale\Generated\Response\HostingUnsuspendServiceResponse;

/**
 * Generated from the Synergy Wholesale WSDL.
 *
 * Do not edit: run `composer generate` instead.
 */
final class HostingApi
{
    public function __construct(private readonly Client $client)
    {
    }

    /**
     * Will retrieve the information associated with the hoid
     *
     * SOAP operation: hostingGetService
     */
    public function getService(
        string $identifier,
        ?string $hoid = null,
    ): HostingGetServiceResponse {
        return HostingGetServiceResponse::fromWire($this->client->call('hostingGetService', [
            'identifier' => $identifier,
            'hoid' => $hoid,
        ]));
    }

    /**
     * Will terminate and re-create the hosting service associated with the supplied HOID
     *
     * SOAP operation: hostingRecreateService
     */
    public function recreateService(
        string $hoid,
        string $newPassword,
        string $api_method,
        string $whmcs_ver,
        string $whmcs_mod_ver,
    ): HostingRecreateServiceResponse {
        return HostingRecreateServiceResponse::fromWire($this->client->call('hostingRecreateService', [
            'hoid' => $hoid,
            'newPassword' => $newPassword,
            'api_method' => $api_method,
            'whmcs_ver' => $whmcs_ver,
            'whmcs_mod_ver' => $whmcs_mod_ver,
        ]));
    }

    /**
     * Will terminate the hosting service associated with the supplied HOID
     *
     * SOAP operation: hostingTerminateService
     */
    public function terminateService(
        string $identifier,
        ?string $hoid = null,
    ): HostingTerminateServiceResponse {
        return HostingTerminateServiceResponse::fromWire($this->client->call('hostingTerminateService', [
            'identifier' => $identifier,
            'hoid' => $hoid,
        ]));
    }

    /**
     * Will create a web hosting account
     *
     * SOAP operation: hostingPurchaseService
     */
    public function purchaseService(
        string $planName,
        string $domain,
        string $email,
        ?string $username = null,
        ?string $password = null,
        ?string $first_name = null,
        ?string $last_name = null,
    ): HostingPurchaseServiceResponse {
        return HostingPurchaseServiceResponse::fromWire($this->client->call('hostingPurchaseService', [
            'planName' => $planName,
            'domain' => $domain,
            'email' => $email,
            'username' => $username,
            'password' => $password,
            'first_name' => $first_name,
            'last_name' => $last_name,
        ]));
    }

    /**
     * Will upgrade the package associated with a web hosting service
     *
     * SOAP operation: hostingChangePackage
     */
    public function changePackage(
        string $identifier,
        string $newPlanName,
        ?string $hoid = null,
    ): HostingChangePackageResponse {
        return HostingChangePackageResponse::fromWire($this->client->call('hostingChangePackage', [
            'identifier' => $identifier,
            'newPlanName' => $newPlanName,
            'hoid' => $hoid,
        ]));
    }

    /**
     * Will change the password associated with the hosting service
     *
     * SOAP operation: hostingChangePassword
     */
    public function changePassword(
        string $identifier,
        string $newPassword,
        ?string $hoid = null,
    ): HostingChangePasswordResponse {
        return HostingChangePasswordResponse::fromWire($this->client->call('hostingChangePassword', [
            'identifier' => $identifier,
            'newPassword' => $newPassword,
            'hoid' => $hoid,
        ]));
    }

    /**
     * Will suspend the hosting service specified
     *
     * SOAP operation: hostingSuspendService
     */
    public function suspendService(
        string $reason,
        string $identifier,
        ?string $hoid = null,
    ): HostingSuspendServiceResponse {
        return HostingSuspendServiceResponse::fromWire($this->client->call('hostingSuspendService', [
            'reason' => $reason,
            'identifier' => $identifier,
            'hoid' => $hoid,
        ]));
    }

    /**
     * Will unsuspend the hosting service specified
     *
     * SOAP operation: hostingUnsuspendService
     */
    public function unsuspendService(
        string $hoid,
        ?string $identifier = null,
    ): HostingUnsuspendServiceResponse {
        return HostingUnsuspendServiceResponse::fromWire($this->client->call('hostingUnsuspendService', [
            'hoid' => $hoid,
            'identifier' => $identifier,
        ]));
    }

    /**
     * Provides a listing of configured hosting packages
     *
     * SOAP operation: hostingListPackages
     */
    public function listPackages(
        ?string $product = null,
    ): HostingListPackagesResponse {
        return HostingListPackagesResponse::fromWire($this->client->call('hostingListPackages', [
            'product' => $product,
        ]));
    }

    /**
     * Will retrieve the login url associated with the hoid
     *
     * SOAP operation: hostingGetLogin
     */
    public function getLogin(
        string $identifier,
        ?string $hoid = null,
    ): HostingGetLoginResponse {
        return HostingGetLoginResponse::fromWire($this->client->call('hostingGetLogin', [
            'identifier' => $identifier,
            'hoid' => $hoid,
        ]));
    }

    /**
     * Will enable the temporary URL on hosting service
     *
     * SOAP operation: hostingEnableTempUrl
     */
    public function enableTempUrl(
        string $identifier,
        ?string $hoid = null,
    ): HostingEnableTempUrlResponse {
        return HostingEnableTempUrlResponse::fromWire($this->client->call('hostingEnableTempUrl', [
            'identifier' => $identifier,
            'hoid' => $hoid,
        ]));
    }

    /**
     * Will disable the temporary URL on hosting service
     *
     * SOAP operation: hostingDisableTempUrl
     */
    public function disableTempUrl(
        string $identifier,
        ?string $hoid = null,
    ): HostingTerminateServiceResponse {
        return HostingTerminateServiceResponse::fromWire($this->client->call('hostingDisableTempUrl', [
            'identifier' => $identifier,
            'hoid' => $hoid,
        ]));
    }

    /**
     * Will check if provided IP address is blocked
     *
     * SOAP operation: hostingCheckFirewall
     */
    public function checkFirewall(
        string $ipAddress,
        string $hoid,
    ): HostingCheckFirewallResponse {
        return HostingCheckFirewallResponse::fromWire($this->client->call('hostingCheckFirewall', [
            'ipAddress' => $ipAddress,
            'hoid' => $hoid,
        ]));
    }

    /**
     * Will unblock firewall if provided IP address is blocked
     *
     * SOAP operation: hostingUnblockFirewall
     */
    public function unblockFirewall(
        string $ipAddress,
        string $hoid,
    ): HostingCheckFirewallResponse {
        return HostingCheckFirewallResponse::fromWire($this->client->call('hostingUnblockFirewall', [
            'ipAddress' => $ipAddress,
            'hoid' => $hoid,
        ]));
    }
}
