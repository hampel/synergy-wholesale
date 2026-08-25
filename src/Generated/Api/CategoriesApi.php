<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Api;

use Hampel\SynergyWholesale\Client;
use Hampel\SynergyWholesale\Generated\Response\AssignDomainCategoryResponse;
use Hampel\SynergyWholesale\Generated\Response\CreateDomainCategoryResponse;
use Hampel\SynergyWholesale\Generated\Response\ListDomainCategoriesResponse;
use Hampel\SynergyWholesale\Generated\Response\RemoveDomainCategoryResponse;
use Hampel\SynergyWholesale\Generated\Response\UnassignDomainCategoryResponse;
use Hampel\SynergyWholesale\Generated\Response\UpdateDomainCategoryResponse;

/**
 * Generated from the Synergy Wholesale WSDL.
 *
 * Do not edit: run `composer generate` instead.
 */
final class CategoriesApi
{
    public function __construct(private readonly Client $client)
    {
    }

    /**
     * This function returns a list of all categories which belong to the reseller account
     *
     * SOAP operation: listDomainCategories
     */
    public function listDomainCategories(): ListDomainCategoriesResponse
    {
        return ListDomainCategoriesResponse::fromWire($this->client->call('listDomainCategories', []));
    }

    /**
     * This function creates a new domain category record to the reseller account
     *
     * SOAP operation: createDomainCategory
     */
    public function createDomainCategory(
        string $name,
        string $note,
    ): CreateDomainCategoryResponse {
        return CreateDomainCategoryResponse::fromWire($this->client->call('createDomainCategory', [
            'name' => $name,
            'note' => $note,
        ]));
    }

    /**
     * This function updates an active domain category record in the reseller account
     *
     * SOAP operation: updateDomainCategory
     */
    public function updateDomainCategory(
        string $id,
        string $name,
        string $note,
    ): UpdateDomainCategoryResponse {
        return UpdateDomainCategoryResponse::fromWire($this->client->call('updateDomainCategory', [
            'id' => $id,
            'name' => $name,
            'note' => $note,
        ]));
    }

    /**
     * This function removes an active domain category record from the reseller account
     *
     * SOAP operation: removeDomainCategory
     */
    public function removeDomainCategory(
        string $id,
    ): RemoveDomainCategoryResponse {
        return RemoveDomainCategoryResponse::fromWire($this->client->call('removeDomainCategory', [
            'id' => $id,
        ]));
    }

    /**
     * This function assigns domain to the provided domain category
     *
     * SOAP operation: assignDomainCategory
     */
    public function assignDomainCategory(
        string $domainName,
        string $categoryId,
        string $categoryName,
    ): AssignDomainCategoryResponse {
        return AssignDomainCategoryResponse::fromWire($this->client->call('assignDomainCategory', [
            'domainName' => $domainName,
            'categoryId' => $categoryId,
            'categoryName' => $categoryName,
        ]));
    }

    /**
     * This function unassigns domain from the provided domain category
     *
     * SOAP operation: unassignDomainCategory
     */
    public function unassignDomainCategory(
        string $domainName,
        string $categoryId,
        string $categoryName,
    ): UnassignDomainCategoryResponse {
        return UnassignDomainCategoryResponse::fromWire($this->client->call('unassignDomainCategory', [
            'domainName' => $domainName,
            'categoryId' => $categoryId,
            'categoryName' => $categoryName,
        ]));
    }
}
