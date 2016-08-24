<?php  namespace SynergyWholesale\Types; 

class ContactTest extends \PHPUnit_Framework_TestCase
{
	public function testBadContact1()
	{
		$this->setExpectedException('SynergyWholesale\Exception\InvalidArgumentException', 'firstname parameter is required');
		$contact = new Contact('', '', '', '', '', '', '', '', new Country('AU'), '', new Phone('+61.111111111'), new Email('foo@example.com'));
	}

	public function testBadContact2()
	{
		$this->setExpectedException('SynergyWholesale\Exception\InvalidArgumentException', 'lastname parameter is required');
		$contact = new Contact('firstname', '', '', '', '', '', '', '', new Country('AU'), '', new Phone('+61.111111111'), new Email('foo@example.com'));
	}

	public function testBadContact3()
	{
		$this->setExpectedException('SynergyWholesale\Exception\InvalidArgumentException', 'address1 parameter is required');
		$contact = new Contact('firstname', 'lastname', '', '', '', '', '', '', new Country('AU'), '', new Phone('+61.111111111'), new Email('foo@example.com'));
	}

	public function testBadContact4()
	{
		$this->setExpectedException('SynergyWholesale\Exception\InvalidArgumentException', 'suburb parameter is required');
		$contact = new Contact('firstname', 'lastname', '', 'address1', '', '', '', '', new Country('AU'), '', new Phone('+61.111111111'), new Email('foo@example.com'));
	}

	public function testBadContact5()
	{
		$this->setExpectedException('SynergyWholesale\Exception\InvalidArgumentException', 'state parameter is required');
		$contact = new Contact('firstname', 'lastname', '', 'address1', '', '', 'suburb', '', new Country('AU'), '', new Phone('+61.111111111'), new Email('foo@example.com'));
	}

	public function testBadContact6()
	{
		$this->setExpectedException('SynergyWholesale\Exception\InvalidArgumentException', 'postcode parameter is required');
		$contact = new Contact('firstname', 'lastname', '', 'address1', '', '', 'suburb', 'state', new Country('AU'), '', new Phone('+61.111111111'), new Email('foo@example.com'));
	}

	public function testContact()
	{
		$contact = new Contact(
			'firstname',
			'lastname',
			'organisation',
			'address1',
			'address2',
			'address3',
			'suburb',
			'state',
			new Country('AU'),
			'postcode',
			new Phone('+61.111111111'),
			new Email('foo@example.com'),
			new Phone('+61.222222222')
		);
		$this->assertEquals('firstname', $contact->getFirstname());
		$this->assertEquals('lastname', $contact->getLastname());
		$this->assertEquals('organisation', $contact->getOrganisation());
		$this->assertEquals('address1', $contact->getAddress1());
		$this->assertEquals('address2', $contact->getAddress2());
		$this->assertEquals('address3', $contact->getAddress3());
		$this->assertEquals('suburb', $contact->getSuburb());
		$this->assertEquals('state', $contact->getState());
		$this->assertInstanceOf('SynergyWholesale\Types\Country', $contact->getCountry());
		$this->assertEquals('AU', $contact->getCountry()->getCountryCode());
		$this->assertEquals('postcode', $contact->getPostcode());
		$this->assertInstanceOf('SynergyWholesale\Types\Phone', $contact->getPhone());
		$this->assertEquals('+61.111111111', $contact->getPhone()->getPhone());
		$this->assertInstanceOf('SynergyWholesale\Types\Email', $contact->getEmail());
		$this->assertEquals('foo@example.com', $contact->getEmail()->getEmail());
		$this->assertInstanceOf('SynergyWholesale\Types\Phone', $contact->getFax());
		$this->assertEquals('+61.222222222', $contact->getFax()->getPhone());
	}

	public function testEquals()
	{
		$contact1 = new Contact(
			'firstname',
			'lastname',
			'organisation',
			'address1',
			'address2',
			'address3',
			'suburb',
			'state',
			new Country('AU'),
			'postcode',
			new Phone('+61.111111111'),
			new Email('foo@example.com'),
			new Phone('+61.222222222')
		);

		$contact2 = new Contact(
			'firstname',
			'lastname',
			'organisation',
			'address1',
			'address2',
			'address3',
			'suburb',
			'state',
			new Country('AU'),
			'postcode',
			new Phone('+61.111111111'),
			new Email('foo@example.com'),
			new Phone('+61.222222222')
		);

		$this->assertTrue($contact1->equals($contact2));
	}

	public function testEqualsWithNullFax()
	{
		$contact1 = new Contact(
			'firstname',
			'lastname',
			'organisation',
			'address1',
			'address2',
			'address3',
			'suburb',
			'state',
			new Country('AU'),
			'postcode',
			new Phone('+61.111111111'),
			new Email('foo@example.com'),
			null
		);

		$contact2 = new Contact(
			'firstname',
			'lastname',
			'organisation',
			'address1',
			'address2',
			'address3',
			'suburb',
			'state',
			new Country('AU'),
			'postcode',
			new Phone('+61.111111111'),
			new Email('foo@example.com'),
			null
		);

		$this->assertTrue($contact1->equals($contact2));
	}

	public function testNotEquals()
	{
		$contact1 = new Contact(
			'firstname',
			'lastname',
			'organisation',
			'address1',
			'address2',
			'address3',
			'suburb',
			'state',
			new Country('AU'),
			'postcode',
			new Phone('+61.111111111'),
			new Email('foo@example.com'),
			new Phone('+61.222222222')
		);

		$contact2 = new Contact(
			'othername',
			'lastname',
			'organisation',
			'address1',
			'address2',
			'address3',
			'suburb',
			'state',
			new Country('AU'),
			'postcode',
			new Phone('+61.111111111'),
			new Email('foo@example.com'),
			new Phone('+61.222222222')
		);

		$this->assertFalse($contact1->equals($contact2));
	}

	public function testNotEqualsWithNullFax()
	{
		$contact1 = new Contact(
			'firstname',
			'lastname',
			'organisation',
			'address1',
			'address2',
			'address3',
			'suburb',
			'state',
			new Country('AU'),
			'postcode',
			new Phone('+61.111111111'),
			new Email('foo@example.com'),
			null
		);

		$contact2 = new Contact(
			'firstname',
			'lastname',
			'organisation',
			'address1',
			'address2',
			'address3',
			'suburb',
			'state',
			new Country('AU'),
			'postcode',
			new Phone('+61.111111111'),
			new Email('foo@example.com'),
			new Phone('+61.222222222')
		);

		$this->assertFalse($contact1->equals($contact2));
	}

	public function testNewFromArray()
	{
		$contact1 = new Contact(
			'firstname',
			'lastname',
			'organisation',
			'address1',
			'address2',
			'address3',
			'suburb',
			'state',
			new Country('AU'),
			'postcode',
			new Phone('+61.111111111'),
			new Email('foo@example.com'),
			new Phone('+61.222222222')
		);

		$contact = [
			'firstname' => 'firstname',
			'lastname' => 'lastname',
			'organisation' => 'organisation',
			'address1' => 'address1',
			'address2' => 'address2',
			'address3' => 'address3',
			'suburb' => 'suburb',
			'state' => 'state',
			'country' => 'AU',
			'postcode' => 'postcode',
			'phone' => '+61.111111111',
			'email' => 'foo@example.com',
			'fax' => '+61.222222222',
		];

		$contact2 = Contact::newFromArray($contact);

		$this->assertTrue($contact1->equals($contact2));
	}

	public function testToArray()
	{
		$contact1 = new Contact(
			'firstname',
			'lastname',
			'organisation',
			'address1',
			'address2',
			'address3',
			'suburb',
			'state',
			new Country('AU'),
			'postcode',
			new Phone('+61.111111111'),
			new Email('foo@example.com'),
			new Phone('+61.222222222')
		);

		$this->assertTrue($contact1->equals(Contact::newFromArray($contact1->toArray())));
	}
}
