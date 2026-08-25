<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Value;

use Hampel\SynergyWholesale\Exception\InvalidArgument;
use Stringable;

/**
 * A validated domain name, and the one piece of real domain logic in this
 * package: working out where the registrable part of a name ends.
 *
 * That is not derivable from the shape of the name. In example.co.nz the
 * registrable part is example.co.nz, while in example.com.au it is
 * example.com.au and in bbc.co.uk it is bbc.co.uk -- but in example.au it is
 * example.au, because .au also sells at the second level. The only way to tell
 * is a list, and the list here is the one Synergy Wholesale actually sells.
 */
final class Domain implements Stringable
{
    /**
     * Country-code second-level domains Synergy Wholesale supports.
     *
     * @var list<string>
     */
    public const SECOND_LEVEL_DOMAINS = [
        'asn.au',
        'com.au',
        'id.au',
        'net.au',
        'org.au',
        'co.nz',
        'geek.nz',
        'net.nz',
        'org.nz',
        'co.uk',
        'me.uk',
        'org.uk',
    ];

    public readonly string $name;

    public function __construct(string $name)
    {
        $name = strtolower(trim($name));

        if (! preg_match('/^((?=[a-z0-9-]{1,63}\.)(xn--)?[a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,63}$/i', $name)) {
            throw new InvalidArgument("Invalid domain name [{$name}]");
        }

        $this->name = $name;
    }

    /** The rightmost label: com, au, nz. */
    public function topLevelDomain(): string
    {
        $parts = $this->parts();

        return (string) array_pop($parts);
    }

    /**
     * The extension the name is registered under: com for example.com,
     * co.nz for example.co.nz.
     */
    public function extension(): string
    {
        $parts = $this->parts();
        $tld = (string) array_pop($parts);

        if (strlen($tld) !== 2 || $parts === []) {
            return $tld;
        }

        $candidate = array_pop($parts) . ".{$tld}";

        return in_array($candidate, self::SECOND_LEVEL_DOMAINS, true) ? $candidate : $tld;
    }

    /** The label immediately left of the extension: example, for www.example.co.nz. */
    public function baseName(): string
    {
        $parts = explode('.', $this->withoutExtension());

        return (string) array_pop($parts);
    }

    /** True when the TLD is a two-letter country code. */
    public function isCountryCode(): bool
    {
        return strlen($this->topLevelDomain()) === 2;
    }

    /** True when the name sits under a supported second-level domain. */
    public function isSecondLevel(): bool
    {
        return in_array($this->extension(), self::SECOND_LEVEL_DOMAINS, true);
    }

    /** True when there is a label to the left of the registrable name. */
    public function isSubDomain(): bool
    {
        return str_contains($this->withoutExtension(), '.');
    }

    /** The registrable name, with any subdomain labels removed. */
    public function registrable(): self
    {
        return new self($this->baseName() . '.' . $this->extension());
    }

    public function equals(self $other): bool
    {
        return $this->name === $other->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    /** @return list<string> */
    private function parts(): array
    {
        return explode('.', $this->name);
    }

    private function withoutExtension(): string
    {
        return substr($this->name, 0, -(strlen($this->extension()) + 1));
    }
}
