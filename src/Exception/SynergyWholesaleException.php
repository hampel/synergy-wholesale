<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Exception;

use Throwable;

/**
 * Marker implemented by every exception this package throws, so a caller can
 * catch the whole package with one clause or each failure mode individually.
 */
interface SynergyWholesaleException extends Throwable
{
}
