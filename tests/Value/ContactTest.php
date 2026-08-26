<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Tests\Value;

use Hampel\SynergyWholesale\Exception\InvalidArgument;
use Hampel\SynergyWholesale\Value\Contact;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ContactTest extends TestCase
{
    #[Test]
    public function a_contact_needs_at_least_one_address_line(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('A contact needs at least one address line');

        self::make(address: []);
    }

    #[Test]
    public function the_country_must_be_a_two_letter_code(): void
    {
        // Rejected here rather than at the registry, where it comes back as a
        // generic failure on a call that has already been charged for.
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('Country must be a two-letter code, got [AUS]');

        self::make(country: 'AUS');
    }

    #[Test]
    public function it_flattens_into_the_role_prefixed_fields_the_api_expects(): void
    {
        $wire = Contact::wire('registrant', self::make());

        $this->assertSame([
            'registrant_firstname' => 'Ada',
            'registrant_lastname' => 'Lovelace',
            'registrant_address' => ['1 Example Street'],
            'registrant_suburb' => 'Sydney',
            'registrant_state' => 'NSW',
            'registrant_country' => 'AU',
            'registrant_postcode' => '2000',
            'registrant_phone' => '+61.290000000',
            'registrant_email' => 'ada@example.com',
        ], $wire);
    }

    /**
     * transferDomain takes one contact set at the top level rather than four
     * prefixed ones, so an empty role has to produce unprefixed fields.
     */
    #[Test]
    public function an_empty_role_produces_unprefixed_fields(): void
    {
        $wire = Contact::wire('', self::make());

        $this->assertArrayHasKey('firstname', $wire);
        $this->assertArrayNotHasKey('_firstname', $wire);
        $this->assertSame('Ada', $wire['firstname']);
    }

    #[Test]
    public function the_two_optional_fields_are_omitted_rather_than_sent_as_null(): void
    {
        $without = Contact::wire('admin', self::make());
        $with = Contact::wire('admin', self::make(organisation: 'Analytical Engines', fax: '+61.290000001'));

        $this->assertArrayNotHasKey('admin_organisation', $without);
        $this->assertArrayNotHasKey('admin_fax', $without);

        $this->assertSame('Analytical Engines', $with['admin_organisation']);
        $this->assertSame('+61.290000001', $with['admin_fax']);
    }

    /**
     * The generated call sites spread every contact unconditionally, so an
     * omitted role must contribute nothing at all -- not a set of null fields,
     * which the API reads as an instruction to blank the contact.
     */
    #[Test]
    public function an_omitted_contact_contributes_nothing(): void
    {
        $this->assertSame([], Contact::wire('technical', null));
    }

    /**
     * @param  list<string>  $address
     */
    private static function make(
        array $address = ['1 Example Street'],
        string $country = 'AU',
        ?string $organisation = null,
        ?string $fax = null,
    ): Contact {
        return new Contact(
            firstname: 'Ada',
            lastname: 'Lovelace',
            address: $address,
            suburb: 'Sydney',
            state: 'NSW',
            country: $country,
            postcode: '2000',
            phone: '+61.290000000',
            email: 'ada@example.com',
            organisation: $organisation,
            fax: $fax,
        );
    }
}
