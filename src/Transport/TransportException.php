<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Transport;

use Hampel\SynergyWholesale\Exception\SynergyWholesaleException;
use RuntimeException;

/**
 * The call could not be completed: no response, or nothing usable in it.
 *
 * Distinct from an ApiError, which means the API answered and said no.
 */
class TransportException extends RuntimeException implements SynergyWholesaleException
{
    public function __construct(
        string $message,
        public readonly string $operation,
        public readonly ?string $faultCode = null,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, 0, $previous);
    }
}
