<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Exception;

use InvalidArgumentException;

/**
 * A value object was handed something it cannot represent. Thrown before any
 * network call, which is the point of having the value objects at all.
 */
class InvalidArgument extends InvalidArgumentException implements SynergyWholesaleException
{
}
