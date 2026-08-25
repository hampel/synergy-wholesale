<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Tests;

use Hampel\SynergyWholesale\Generated\Response\CheckDomainResponse;
use Hampel\SynergyWholesale\Transport\FixtureTransport;
use Hampel\SynergyWholesale\Wire;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class WireTest extends TestCase
{
    #[Test]
    public function a_missing_field_is_null_rather_than_an_error(): void
    {
        $raw = FixtureTransport::response(['status' => 'OK']);

        $this->assertNull(Wire::string($raw, 'nothingHere'));
        $this->assertNull(Wire::strings($raw, 'nothingHere'));
        $this->assertNull(Wire::objects($raw, 'nothingHere', CheckDomainResponse::class));
    }

    #[Test]
    #[DataProvider('booleans')]
    public function it_coerces_the_many_spellings_of_true_and_false(mixed $value, ?bool $expected): void
    {
        $this->assertSame($expected, Wire::toBool($value));
    }

    /** @return iterable<string, array{mixed, bool|null}> */
    public static function booleans(): iterable
    {
        yield 'real true' => [true, true];
        yield 'string true' => ['true', true];
        yield 'T' => ['T', true];
        yield 'Y' => ['Y', true];
        yield 'yes' => ['yes', true];
        yield 'enabled' => ['enabled', true];
        yield 'one as string' => ['1', true];
        yield 'one as int' => [1, true];
        yield 'real false' => [false, false];
        yield 'string false' => ['false', false];
        yield 'N' => ['N', false];
        yield 'disabled' => ['disabled', false];
        yield 'zero as string' => ['0', false];
        yield 'zero as int' => [0, false];
        yield 'unrecognised' => ['maybe', null];
    }

    /**
     * The single-element case is the one that bites in production: SOAP-ENC
     * gives no way to distinguish a list of one from a bare value, so an
     * account with exactly one nameserver returns an object where an account
     * with two returns an array.
     */
    #[Test]
    public function a_single_element_list_arrives_as_a_bare_value_and_is_normalised(): void
    {
        $many = FixtureTransport::response(['nameServers' => ['ns1.example.com', 'ns2.example.com']]);
        $one = FixtureTransport::response(['nameServers' => 'ns1.example.com']);

        $this->assertSame(['ns1.example.com', 'ns2.example.com'], Wire::strings($many, 'nameServers'));
        $this->assertSame(['ns1.example.com'], Wire::strings($one, 'nameServers'));
    }

    #[Test]
    public function it_coerces_scalars_to_the_declared_type(): void
    {
        $raw = FixtureTransport::response([
            'available' => '1',
            'costPrice' => 12.95,
            'premium' => 'false',
        ]);

        $this->assertSame(1, Wire::int($raw, 'available'));
        // Prices stay strings: the wire value verbatim, so a caller wanting
        // exact arithmetic still can.
        $this->assertSame('12.95', Wire::string($raw, 'costPrice'));
        $this->assertFalse(Wire::bool($raw, 'premium'));
    }

    #[Test]
    public function an_empty_string_reads_as_absent(): void
    {
        $raw = FixtureTransport::response(['domainRoid' => '']);

        $this->assertNull(Wire::string($raw, 'domainRoid'));
    }

    #[Test]
    public function a_non_numeric_value_in_an_int_field_is_null_not_zero(): void
    {
        $raw = FixtureTransport::response(['dnsConfig' => 'not a number']);

        $this->assertNull(Wire::int($raw, 'dnsConfig'));
    }
}
