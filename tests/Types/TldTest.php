<?php  namespace SynergyWholesale\Types;

class TldTest extends \PHPUnit_Framework_TestCase {

	public function testBadTldTooManyParts()
	{
		$this->setExpectedException('SynergyWholesale\Exception\InvalidArgumentException', 'Invalid Top Level Domain [example.com.au] - should have no more than 2 parts');

		new Tld('example.com.au');
	}

	public function testBadTldCountryCode()
	{
		$this->setExpectedException('SynergyWholesale\Exception\InvalidArgumentException', 'Invalid Top Level Domain [com.abc] - Country Codes have a maximum of 2 characters');

		new Tld('com.abc');
	}

	public function testBadTldInvalid()
	{
		$this->setExpectedException('SynergyWholesale\Exception\InvalidArgumentException', 'Invalid Top Level Domain [com-x.au]');

		new Tld('com-x.au');
	}

	public function testTld()
	{
		$tld = new Tld('foo');

		$this->assertEquals('foo', $tld->getTld());
		$this->assertEquals('foo', strval($tld));
		$this->assertFalse($tld->isCcTld());
		$this->assertNull($tld->getCcTld());
		$this->assertTrue($tld->equals(new Tld('foo')));

		$tld = new Tld('com.au');

		$this->assertEquals('com.au', $tld->getTld());
		$this->assertEquals('com.au', strval($tld));
		$this->assertTrue($tld->isCcTld());
		$this->assertEquals('au', $tld->getCcTld());
		$this->assertTrue($tld->equals(new Tld('com.au')));

		// publicly registerable subdomain acting like a ccTLD
		$tld = new Tld('eu.com');

		$this->assertEquals('eu.com', $tld->getTld());
		$this->assertEquals('eu.com', strval($tld));
		$this->assertFalse($tld->isCcTld());
		$this->assertNull($tld->getCcTld());
		$this->assertTrue($tld->equals(new Tld('eu.com')));
	}
}
