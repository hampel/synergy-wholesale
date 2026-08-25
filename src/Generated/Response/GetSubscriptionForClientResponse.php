<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "getSubscriptionForClientResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class GetSubscriptionForClientResponse implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $productId,
        public readonly ?string $productName,
        public readonly ?string $quantity,
        public readonly ?string $monthlyCost,
        /** @var list<GetSubscriptionAddonsArraySingleEntry>|null */
        public readonly ?array $addons,
        /** @var list<GetSubscriptionTasksArraySingleEntry>|null */
        public readonly ?array $tasks,
        public readonly ?string $subscriptionStatus,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            productId: Wire::string($raw, 'productId'),
            productName: Wire::string($raw, 'productName'),
            quantity: Wire::string($raw, 'quantity'),
            monthlyCost: Wire::string($raw, 'monthlyCost'),
            addons: Wire::objects($raw, 'addons', GetSubscriptionAddonsArraySingleEntry::class),
            tasks: Wire::objects($raw, 'tasks', GetSubscriptionTasksArraySingleEntry::class),
            subscriptionStatus: Wire::string($raw, 'subscriptionStatus'),
        );
    }
}
