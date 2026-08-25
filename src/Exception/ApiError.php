<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Exception;

use RuntimeException;

/**
 * The API answered and said no.
 *
 * Every one of the 143 operations returns the same envelope -- a `status` and
 * an `errorMessage` -- and every failure status is prefixed `ERR_`. That
 * uniformity is why this is one exception rather than a hierarchy: the
 * distinguishing information is the status string, of which the published
 * documentation lists around 100.
 *
 * The status is deliberately a string rather than an enum. An enum would have
 * to be exhaustive, and a status the registry invents between releases would
 * then fail to construct -- turning a readable error into a crash at the worst
 * possible moment.
 */
class ApiError extends RuntimeException implements SynergyWholesaleException
{
    public function __construct(
        public readonly string $status,
        string $message,
        public readonly string $operation,
        public readonly object $response,
    ) {
        parent::__construct($message);
    }

    /**
     * True when the failure is an authentication or authorisation problem,
     * which is worth distinguishing because it is never worth retrying and
     * usually means the IP whitelist, not the credentials.
     */
    public function isAuthFailure(): bool
    {
        return in_array($this->status, [
            'ERR_RESELLER_NOT_AUTHORISED',
            'ERR_LOGIN_FAILED',
        ], true);
    }
}
