<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "salePricingResponseArray".
 *
 * Do not edit: run `composer generate` instead.
 */
final class SalePricingResponseArray implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $transfer,
        public readonly ?string $renew,
        public readonly ?string $register_1_year,
        public readonly ?string $register_2_year,
        public readonly ?string $register_3_year,
        public readonly ?string $register_4_year,
        public readonly ?string $register_5_year,
        public readonly ?string $register_6_year,
        public readonly ?string $register_7_year,
        public readonly ?string $register_8_year,
        public readonly ?string $register_9_year,
        public readonly ?string $register_10_year,
        public readonly ?string $start_sale_date,
        public readonly ?string $end_sale_date,
        public readonly ?string $premium_discount_percentage,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            transfer: Wire::string($raw, 'transfer'),
            renew: Wire::string($raw, 'renew'),
            register_1_year: Wire::string($raw, 'register_1_year'),
            register_2_year: Wire::string($raw, 'register_2_year'),
            register_3_year: Wire::string($raw, 'register_3_year'),
            register_4_year: Wire::string($raw, 'register_4_year'),
            register_5_year: Wire::string($raw, 'register_5_year'),
            register_6_year: Wire::string($raw, 'register_6_year'),
            register_7_year: Wire::string($raw, 'register_7_year'),
            register_8_year: Wire::string($raw, 'register_8_year'),
            register_9_year: Wire::string($raw, 'register_9_year'),
            register_10_year: Wire::string($raw, 'register_10_year'),
            start_sale_date: Wire::string($raw, 'start_sale_date'),
            end_sale_date: Wire::string($raw, 'end_sale_date'),
            premium_discount_percentage: Wire::string($raw, 'premium_discount_percentage'),
        );
    }
}
