<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Api;

use Hampel\SynergyWholesale\Client;
use Hampel\SynergyWholesale\Generated\Request\SubscriptionOrderArraySingleEntry;
use Hampel\SynergyWholesale\Generated\Response\CreateClientResponse;
use Hampel\SynergyWholesale\Generated\Response\GetClientResponse;
use Hampel\SynergyWholesale\Generated\Response\GetSubscriptionForClientResponse;
use Hampel\SynergyWholesale\Generated\Response\GetSubscriptionsForClientResponse;
use Hampel\SynergyWholesale\Generated\Response\GetSubscriptionsForClientsResponse;
use Hampel\SynergyWholesale\Generated\Response\ListClientsResponse;
use Hampel\SynergyWholesale\Generated\Response\PurchaseSubscriptionResponse;
use Hampel\SynergyWholesale\Generated\Response\SuspendSubscriptionResponse;
use Hampel\SynergyWholesale\Generated\Response\TerminateSubscriptionResponse;
use Hampel\SynergyWholesale\Generated\Response\UnsuspendSubscriptionResponse;
use Hampel\SynergyWholesale\Generated\Response\UpdateClientResponse;
use Hampel\SynergyWholesale\Generated\Response\UpdateSubscriptionQuantityResponse;

/**
 * Generated from the Synergy Wholesale WSDL.
 *
 * Do not edit: run `composer generate` instead.
 */
final class SubscriptionsApi
{
    public function __construct(private readonly Client $client)
    {
    }

    /**
     * This function creates a new client to be used for subscriptions
     *
     * SOAP operation: subscriptionCreateClient
     */
    public function createClient(
        string $firstname,
        string $lastname,
        string $email,
        string $phone,
        string $address,
        string $address2,
        string $suburb,
        string $postcode,
        string $state,
        string $country,
        string $company,
        string $password,
        string $description,
        ?string $domainPrefix = null,
    ): CreateClientResponse {
        return CreateClientResponse::fromWire($this->client->call('subscriptionCreateClient', [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'address2' => $address2,
            'suburb' => $suburb,
            'postcode' => $postcode,
            'state' => $state,
            'country' => $country,
            'company' => $company,
            'password' => $password,
            'description' => $description,
            'domainPrefix' => $domainPrefix,
        ]));
    }

    /**
     * This function updates a client that is used for subscriptions
     *
     * SOAP operation: subscriptionUpdateClient
     */
    public function updateClient(
        string $identifier,
        string $firstname,
        string $lastname,
        string $company,
        string $email,
        string $phone,
        string $address,
        string $address2,
        string $suburb,
        string $postcode,
        string $state,
        string $country,
        string $description,
    ): UpdateClientResponse {
        return UpdateClientResponse::fromWire($this->client->call('subscriptionUpdateClient', [
            'identifier' => $identifier,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'company' => $company,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'address2' => $address2,
            'suburb' => $suburb,
            'postcode' => $postcode,
            'state' => $state,
            'country' => $country,
            'description' => $description,
        ]));
    }

    /**
     * This function retrieves a client that is used for subscriptions
     *
     * SOAP operation: subscriptionGetClient
     */
    public function getClient(
        string $identifier,
    ): GetClientResponse {
        return GetClientResponse::fromWire($this->client->call('subscriptionGetClient', [
            'identifier' => $identifier,
        ]));
    }

    /**
     * This function retrieves all subscriptions for a client
     *
     * SOAP operation: subscriptionListClientSubscriptions
     */
    public function listClientSubscriptions(
        string $identifier,
    ): GetSubscriptionsForClientResponse {
        return GetSubscriptionsForClientResponse::fromWire($this->client->call('subscriptionListClientSubscriptions', [
            'identifier' => $identifier,
        ]));
    }

    /**
     * This function retrieves all clients
     *
     * SOAP operation: subscriptionListClients
     */
    public function listClients(
        ?int $page = null,
    ): ListClientsResponse {
        return ListClientsResponse::fromWire($this->client->call('subscriptionListClients', [
            'page' => $page,
        ]));
    }

    /**
     * This function retrieves all purchasable subscriptions for a client
     *
     * SOAP operation: subscriptionListPurchasable
     */
    public function listPurchasable(): GetSubscriptionsForClientsResponse
    {
        return GetSubscriptionsForClientsResponse::fromWire($this->client->call('subscriptionListPurchasable', []));
    }

    /**
     * This function retrieves a subscription for a client
     *
     * SOAP operation: subscriptionGetDetails
     */
    public function getDetails(
        string $identifier,
    ): GetSubscriptionForClientResponse {
        return GetSubscriptionForClientResponse::fromWire($this->client->call('subscriptionGetDetails', [
            'identifier' => $identifier,
        ]));
    }

    /**
     * This function purchases subscriptions
     *
     * @param list<SubscriptionOrderArraySingleEntry> $subscriptionOrder
     *
     * SOAP operation: subscriptionPurchase
     */
    public function purchase(
        string $identifier,
        array $subscriptionOrder,
    ): PurchaseSubscriptionResponse {
        return PurchaseSubscriptionResponse::fromWire($this->client->call('subscriptionPurchase', [
            'identifier' => $identifier,
            'subscriptionOrder' => array_map(static fn (SubscriptionOrderArraySingleEntry $e): array => $e->toWire(), $subscriptionOrder),
        ]));
    }

    /**
     * This function updates a subscription quantity and performs a transaction
     *
     * SOAP operation: subscriptionUpdateQuantity
     */
    public function updateQuantity(
        string $identifier,
        string $quantity,
    ): UpdateSubscriptionQuantityResponse {
        return UpdateSubscriptionQuantityResponse::fromWire($this->client->call('subscriptionUpdateQuantity', [
            'identifier' => $identifier,
            'quantity' => $quantity,
        ]));
    }

    /**
     * This function suspends a subscription and any addons
     *
     * SOAP operation: subscriptionSuspend
     */
    public function suspend(
        string $identifier,
    ): SuspendSubscriptionResponse {
        return SuspendSubscriptionResponse::fromWire($this->client->call('subscriptionSuspend', [
            'identifier' => $identifier,
        ]));
    }

    /**
     * This function terminates a subscription and any addons
     *
     * SOAP operation: subscriptionTerminate
     */
    public function terminate(
        string $identifier,
    ): TerminateSubscriptionResponse {
        return TerminateSubscriptionResponse::fromWire($this->client->call('subscriptionTerminate', [
            'identifier' => $identifier,
        ]));
    }

    /**
     * This function unsuspends a subscription and any addons
     *
     * SOAP operation: subscriptionUnsuspend
     */
    public function unsuspend(
        string $identifier,
    ): UnsuspendSubscriptionResponse {
        return UnsuspendSubscriptionResponse::fromWire($this->client->call('subscriptionUnsuspend', [
            'identifier' => $identifier,
        ]));
    }
}
