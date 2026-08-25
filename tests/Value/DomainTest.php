<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Tests\Value;

use Hampel\SynergyWholesale\Exception\InvalidArgument;
use Hampel\SynergyWholesale\Value\Domain;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class DomainTest extends TestCase
{
    #[Test]
    #[DataProvider('invalidNames')]
    public function it_rejects_anything_that_is_not_a_domain_name(string $name): void
    {
        $this->expectException(InvalidArgument::class);

        new Domain($name);
    }

    /** @return iterable<string, array{string}> */
    public static function invalidNames(): iterable
    {
        yield 'no extension' => ['example'];
        yield 'empty' => [''];
        yield 'trailing dot only' => ['example.'];
        yield 'space inside' => ['exa mple.com'];
        // The v1 pattern was unanchored, so it matched a domain ANYWHERE in the
        // string and accepted all of these as valid names.
        yield 'leading junk' => ['not a domain example.com'];
        yield 'trailing junk' => ['example.com and more'];
        yield 'url' => ['https://example.com/path'];
    }

    #[Test]
    public function it_reads_a_plain_gtld(): void
    {
        $domain = new Domain('example.com');

        $this->assertSame('example.com', $domain->name);
        $this->assertSame('example.com', (string) $domain);
        $this->assertSame('com', $domain->topLevelDomain());
        $this->assertSame('com', $domain->extension());
        $this->assertSame('example', $domain->baseName());
        $this->assertFalse($domain->isCountryCode());
        $this->assertFalse($domain->isSecondLevel());
        $this->assertFalse($domain->isSubDomain());
    }

    #[Test]
    public function it_reads_a_subdomain_of_a_second_level_cctld(): void
    {
        $domain = new Domain('www.example.co.nz');

        $this->assertSame('nz', $domain->topLevelDomain());
        $this->assertSame('co.nz', $domain->extension());
        $this->assertSame('example', $domain->baseName());
        $this->assertTrue($domain->isCountryCode());
        $this->assertTrue($domain->isSecondLevel());
        $this->assertTrue($domain->isSubDomain());
        $this->assertSame('example.co.nz', (string) $domain->registrable());
    }

    /**
     * A two-letter TLD does not imply a second level. .au now sells directly,
     * and treating example.au as though "example" were the second-level part
     * would produce a nonsense extension.
     */
    #[Test]
    public function it_does_not_assume_a_two_letter_tld_is_second_level(): void
    {
        $domain = new Domain('example.au');

        $this->assertSame('au', $domain->topLevelDomain());
        $this->assertSame('au', $domain->extension());
        $this->assertSame('example', $domain->baseName());
        $this->assertTrue($domain->isCountryCode());
        $this->assertFalse($domain->isSecondLevel());
    }

    #[Test]
    #[DataProvider('extensions')]
    public function it_finds_the_extension(string $name, string $extension, string $base): void
    {
        $domain = new Domain($name);

        $this->assertSame($extension, $domain->extension());
        $this->assertSame($base, $domain->baseName());
    }

    /** @return iterable<string, array{string, string, string}> */
    public static function extensions(): iterable
    {
        yield 'com.au' => ['example.com.au', 'com.au', 'example'];
        yield 'co.uk' => ['bbc.co.uk', 'co.uk', 'bbc'];
        yield 'id.au' => ['someone.id.au', 'id.au', 'someone'];
        // .de is a two-letter TLD with no supported second level, so the whole
        // of "co" is the registrable name here, not part of the extension.
        yield 'unsupported second level' => ['co.de', 'de', 'co'];
        yield 'long gtld' => ['example.photography', 'photography', 'example'];
        yield 'idn' => ['xn--bcher-kva.com', 'com', 'xn--bcher-kva'];
        yield 'hyphenated' => ['some-thing.net.au', 'net.au', 'some-thing'];
    }

    #[Test]
    public function it_lowercases_and_trims(): void
    {
        $this->assertSame('example.com', (new Domain('  ExAmPle.COM  '))->name);
    }

    #[Test]
    public function it_compares_by_value(): void
    {
        $this->assertTrue((new Domain('example.com'))->equals(new Domain('EXAMPLE.com')));
        $this->assertFalse((new Domain('example.com'))->equals(new Domain('example.net')));
    }
}
