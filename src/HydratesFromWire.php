<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale;

/**
 * Implemented by every generated response class.
 *
 * Its job is to let static analysis follow the hydration: without it, the
 * helpers in Wire take a class-string and call a static method on it that
 * nothing has promised exists.
 */
interface HydratesFromWire
{
    public static function fromWire(object $raw): static;
}
