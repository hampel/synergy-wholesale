<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Generated\Request;

/**
 * Generated from the Synergy Wholesale WSDL type "rawDomainInfoRequestSingle".
 *
 * Do not edit: run `composer generate` instead.
 */
final class RawDomainInfoRequestSingle
{
    public function __construct(
        public readonly string $domain,
        public readonly string $authInfo,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toWire(): array
    {
        return [
            'domain' => $this->domain,
            'authInfo' => $this->authInfo,
        ];
    }
}
