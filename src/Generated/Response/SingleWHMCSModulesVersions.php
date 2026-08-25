<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Response;

use Hampel\SynergyWholesale\HydratesFromWire;
use Hampel\SynergyWholesale\Wire;

/**
 * Generated from the Synergy Wholesale WSDL type "singleWHMCSModulesVersions".
 *
 * Do not edit: run `composer generate` instead.
 */
final class SingleWHMCSModulesVersions implements HydratesFromWire
{
    public function __construct(
        public readonly ?string $key,
        public readonly ?string $moduleName,
        public readonly ?string $fileName,
        public readonly ?string $moduleVersion,
    ) {
    }

    public static function fromWire(object $raw): static
    {
        return new self(
            key: Wire::string($raw, 'key'),
            moduleName: Wire::string($raw, 'moduleName'),
            fileName: Wire::string($raw, 'fileName'),
            moduleVersion: Wire::string($raw, 'moduleVersion'),
        );
    }
}
