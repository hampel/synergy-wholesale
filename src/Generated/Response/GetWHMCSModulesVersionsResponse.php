<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "getWHMCSModulesVersionsResponse".
 *
 * Do not edit: run `composer generate` instead.
 */
final class GetWHMCSModulesVersionsResponse implements HydratesFromWire
{
    public function __construct(
        /** @var list<SingleWHMCSModulesVersions>|null */
        public readonly ?array $data,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            data: Wire::objects($raw, 'data', SingleWHMCSModulesVersions::class),
        );
    }
}
