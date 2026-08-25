<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale;

/**
 * Coercion helpers used by the generated response classes.
 *
 * The SOAP responses arrive as stdClass graphs with no type discipline worth
 * relying on: the same field comes back as "1", 1 or true depending on the
 * operation, and absent fields are simply not there. Every helper here is
 * therefore total -- it returns null rather than throwing -- because a client
 * whose job is to report what the registry said must not fail to construct
 * just because a field it did not need was missing.
 *
 * There is one method per target type rather than one method taking a type
 * name. That is not stylistic: a single method has to return the union of
 * everything it might produce, and every generated constructor then receives a
 * union where it declared one type.
 */
final class Wire
{
    /** Reads a string. An empty string is treated as absent. */
    public static function string(object $raw, string $key): ?string
    {
        $value = self::raw($raw, $key);

        if (! is_scalar($value)) {
            return null;
        }

        $value = is_bool($value) ? ($value ? 'true' : 'false') : (string) $value;

        return $value === '' ? null : $value;
    }

    /** Reads an integer. A non-numeric value is absent, not zero. */
    public static function int(object $raw, string $key): ?int
    {
        $value = self::raw($raw, $key);

        if (is_bool($value)) {
            return $value ? 1 : 0;
        }

        return is_int($value) || (is_string($value) && is_numeric($value)) ? (int) $value : null;
    }

    /** Reads a boolean in any of the spellings the API uses. */
    public static function bool(object $raw, string $key): ?bool
    {
        return self::toBool(self::raw($raw, $key));
    }

    /** @return list<string>|null */
    public static function strings(object $raw, string $key): ?array
    {
        return self::mapList($raw, $key, static function (mixed $item): ?string {
            if (! is_scalar($item)) {
                return null;
            }

            return is_bool($item) ? ($item ? 'true' : 'false') : (string) $item;
        });
    }

    /** @return list<int>|null */
    public static function ints(object $raw, string $key): ?array
    {
        return self::mapList($raw, $key, static function (mixed $item): ?int {
            if (is_bool($item)) {
                return $item ? 1 : 0;
            }

            return is_int($item) || (is_string($item) && is_numeric($item)) ? (int) $item : null;
        });
    }

    /** @return list<bool>|null */
    public static function bools(object $raw, string $key): ?array
    {
        return self::mapList($raw, $key, static fn (mixed $item): ?bool => self::toBool($item));
    }

    /**
     * Hydrates a single nested object.
     *
     * @template T of HydratesFromWire
     *
     * @param  class-string<T>  $class
     * @return T|null
     */
    public static function object(object $raw, string $key, string $class): ?HydratesFromWire
    {
        $value = self::raw($raw, $key);

        return is_object($value) ? $class::fromWire($value) : null;
    }

    /**
     * Hydrates a list of nested objects.
     *
     * SOAP-ENC arrays of length one arrive as a bare object rather than an
     * array of one -- there is nothing in the encoding that distinguishes
     * "a list with one entry" from "one entry" -- so a single object is
     * normalised back into a list here. Getting this wrong produces a client
     * that works until an account happens to have exactly one of something.
     *
     * @template T of HydratesFromWire
     *
     * @param  class-string<T>  $class
     * @return list<T>|null
     */
    public static function objects(object $raw, string $key, string $class): ?array
    {
        $value = self::raw($raw, $key);

        if ($value === null) {
            return null;
        }

        $out = [];
        foreach (is_array($value) ? $value : [$value] as $item) {
            if (is_object($item)) {
                $out[] = $class::fromWire($item);
            }
        }

        return $out;
    }

    /**
     * Hydrates a list of lists of nested objects.
     *
     * A few response types nest one level deeper than the rest: listClients
     * returns clientListArray, whose entries are clientListTypeArray, whose
     * entries are the actual records. Flattening that away would lose the
     * grouping the API is expressing.
     *
     * @template T of HydratesFromWire
     *
     * @param  class-string<T>  $class
     * @return list<list<T>>|null
     */
    public static function objectLists(object $raw, string $key, string $class): ?array
    {
        $value = self::raw($raw, $key);

        if ($value === null) {
            return null;
        }

        $out = [];
        foreach (is_array($value) ? $value : [$value] as $group) {
            $inner = [];
            foreach (is_array($group) ? $group : [$group] as $item) {
                if (is_object($item)) {
                    $inner[] = $class::fromWire($item);
                }
            }
            $out[] = $inner;
        }

        return $out;
    }

    /**
     * The API expresses booleans as any of true, "true", "T", "Y", "yes",
     * "on", "enabled" or 1, and their negatives, depending on the field and
     * the age of the endpoint.
     */
    public static function toBool(mixed $value): ?bool
    {
        if (is_bool($value)) {
            return $value;
        }

        if (is_int($value)) {
            return $value !== 0;
        }

        if (! is_string($value)) {
            return null;
        }

        return match (strtolower(trim($value))) {
            'y', 'yes', 'on', 't', 'true', 'enabled', '1' => true,
            'n', 'no', 'off', 'f', 'false', 'disabled', '0', '' => false,
            default => null,
        };
    }

    private static function raw(object $raw, string $key): mixed
    {
        /** @var mixed */
        return $raw->{$key} ?? null;
    }

    /**
     * @template TItem
     *
     * @param  callable(mixed): (TItem|null)  $map
     * @return list<TItem>|null
     */
    private static function mapList(object $raw, string $key, callable $map): ?array
    {
        $value = self::raw($raw, $key);

        if ($value === null) {
            return null;
        }

        $out = [];
        foreach (is_array($value) ? $value : [$value] as $item) {
            $mapped = $map($item);
            if ($mapped !== null) {
                $out[] = $mapped;
            }
        }

        return $out;
    }
}
