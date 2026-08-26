<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Tests;

use Hampel\SynergyWholesale\Generated\Response\CheckDomainResponse;
use Hampel\SynergyWholesale\Generated\Response\ClientListArraySingleEntry;
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

    #[Test]
    public function the_list_helpers_coerce_each_element_and_drop_what_they_cannot(): void
    {
        $raw = FixtureTransport::response([
            'ids' => [1, '2', true, 'not a number'],
            'flags' => ['Y', 'off', 1, 'maybe'],
        ]);

        // Same rule as the scalar helpers, applied per element: an element that
        // will not coerce is dropped rather than becoming a zero or a false.
        $this->assertSame([1, 2, 1], Wire::ints($raw, 'ids'));
        $this->assertSame([true, false, true], Wire::bools($raw, 'flags'));
    }

    #[Test]
    public function the_list_helpers_normalise_a_single_element_too(): void
    {
        $raw = FixtureTransport::response(['ids' => '7', 'flags' => 'enabled']);

        $this->assertSame([7], Wire::ints($raw, 'ids'));
        $this->assertSame([true], Wire::bools($raw, 'flags'));
    }

    #[Test]
    public function a_missing_list_is_null_but_an_unusable_one_is_empty(): void
    {
        $raw = FixtureTransport::response(['ids' => ['x', 'y']]);

        // The distinction matters: null means the API did not send the field,
        // [] means it sent one with nothing usable in it.
        $this->assertNull(Wire::ints($raw, 'nothingHere'));
        $this->assertNull(Wire::bools($raw, 'nothingHere'));
        $this->assertSame([], Wire::ints($raw, 'ids'));
    }

    #[Test]
    public function it_hydrates_a_single_nested_object(): void
    {
        $raw = FixtureTransport::response([
            'result' => ['available' => '1', 'costPrice' => '12.95'],
        ]);

        $hydrated = Wire::object($raw, 'result', CheckDomainResponse::class);

        $this->assertInstanceOf(CheckDomainResponse::class, $hydrated);
        $this->assertSame(1, $hydrated->available);
        $this->assertSame('12.95', $hydrated->costPrice);
    }

    #[Test]
    public function a_nested_object_field_that_is_not_an_object_is_null(): void
    {
        $raw = FixtureTransport::response(['result' => 'ERR_SOMETHING']);

        $this->assertNull(Wire::object($raw, 'result', CheckDomainResponse::class));
        $this->assertNull(Wire::object($raw, 'nothingHere', CheckDomainResponse::class));
    }

    /**
     * listClients returns clientListArray, whose entries are themselves arrays
     * of the actual records. Flattening that away would lose the grouping the
     * API is expressing, so the extra level is preserved.
     */
    #[Test]
    public function it_preserves_the_extra_level_in_a_list_of_lists(): void
    {
        $raw = FixtureTransport::response([
            'clientsList' => [
                [['clientId' => '1', 'name' => 'First'], ['clientId' => '2', 'name' => 'Second']],
                [['clientId' => '3', 'name' => 'Third']],
            ],
        ]);

        $groups = Wire::objectLists($raw, 'clientsList', ClientListArraySingleEntry::class);

        $this->assertNotNull($groups);
        $this->assertCount(2, $groups);
        $this->assertCount(2, $groups[0]);
        $this->assertCount(1, $groups[1]);
        $this->assertSame('First', $groups[0][0]->name);
        $this->assertSame('Third', $groups[1][0]->name);
    }

    /**
     * Both levels can collapse independently, and an account with one client is
     * exactly when they do.
     */
    #[Test]
    public function a_list_of_lists_normalises_a_collapsed_level_at_either_depth(): void
    {
        $bothCollapsed = FixtureTransport::response([
            'clientsList' => ['clientId' => '1', 'name' => 'Only'],
        ]);

        $innerCollapsed = FixtureTransport::response([
            'clientsList' => [
                ['clientId' => '1', 'name' => 'First'],
                ['clientId' => '2', 'name' => 'Second'],
            ],
        ]);

        $one = Wire::objectLists($bothCollapsed, 'clientsList', ClientListArraySingleEntry::class);

        $this->assertNotNull($one);
        $this->assertCount(1, $one);
        $this->assertCount(1, $one[0]);
        $this->assertSame('Only', $one[0][0]->name);

        // Two records, each a group of one -- there is nothing on the wire that
        // says otherwise, so this is the reading, not a guess.
        $two = Wire::objectLists($innerCollapsed, 'clientsList', ClientListArraySingleEntry::class);

        $this->assertNotNull($two);
        $this->assertCount(2, $two);
        $this->assertCount(1, $two[0]);
        $this->assertSame('Second', $two[1][0]->name);
    }

    #[Test]
    public function a_missing_list_of_lists_is_null(): void
    {
        $raw = FixtureTransport::response(['status' => 'OK']);

        $this->assertNull(Wire::objectLists($raw, 'clientsList', ClientListArraySingleEntry::class));
    }

    #[Test]
    public function a_boolean_in_an_int_field_reads_as_one_or_zero(): void
    {
        $raw = FixtureTransport::response(['idProtect' => true, 'autoRenew' => false]);

        $this->assertSame(1, Wire::int($raw, 'idProtect'));
        $this->assertSame(0, Wire::int($raw, 'autoRenew'));
    }

    #[Test]
    public function a_non_scalar_element_is_dropped_from_a_string_list(): void
    {
        $raw = FixtureTransport::response([
            'nameServers' => ['ns1.example.com', ['nested' => 'thing'], 'ns2.example.com'],
        ]);

        $this->assertSame(['ns1.example.com', 'ns2.example.com'], Wire::strings($raw, 'nameServers'));
    }

    /**
     * The same single-element collapse the string lists have, on the path the
     * generated responses use most: an account with one of something returns a
     * bare object where an account with two returns an array.
     */
    #[Test]
    public function it_hydrates_a_list_of_objects_and_normalises_a_single_one(): void
    {
        $many = FixtureTransport::response([
            'results' => [['available' => '1'], ['available' => '0']],
        ]);

        $one = FixtureTransport::response([
            'results' => ['available' => '1', 'costPrice' => '12.95'],
        ]);

        $hydrated = Wire::objects($many, 'results', CheckDomainResponse::class);

        $this->assertNotNull($hydrated);
        $this->assertCount(2, $hydrated);
        $this->assertSame(1, $hydrated[0]->available);
        $this->assertSame(0, $hydrated[1]->available);

        $single = Wire::objects($one, 'results', CheckDomainResponse::class);

        $this->assertNotNull($single);
        $this->assertCount(1, $single);
        $this->assertSame('12.95', $single[0]->costPrice);
    }

    #[Test]
    public function a_non_object_element_is_dropped_from_an_object_list(): void
    {
        $raw = FixtureTransport::response(['results' => [['available' => '1'], 'ERR_SOMETHING']]);

        $hydrated = Wire::objects($raw, 'results', CheckDomainResponse::class);

        $this->assertNotNull($hydrated);
        $this->assertCount(1, $hydrated);
    }
}
