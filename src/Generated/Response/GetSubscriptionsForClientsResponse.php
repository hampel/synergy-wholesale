<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "getSubscriptionsForClientsResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class GetSubscriptionsForClientsResponse implements HydratesFromWire
{
    public function __construct(
        /** @var list<list<SubscriptionProductListArraySingleEntry>>|null */
        public readonly ?array $subscriptionList,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            subscriptionList: Wire::objectLists($raw, 'subscriptionList', SubscriptionProductListArraySingleEntry::class),
        );
    }
}
