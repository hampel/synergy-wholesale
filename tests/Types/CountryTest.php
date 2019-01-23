<?php  namespace SynergyWholesale\Types; 

use PHPUnit\Framework\TestCase;

class CountryTest extends TestCase {

	public function testBadCountry1()
	{
		$this->expectException('SynergyWholesale\Exception\UnknownCountryException', 'Unknown country []');

		$country = new Country('');
	}

	public function testBadCountry2()
	{
		$this->expectException('SynergyWholesale\Exception\UnknownCountryException', 'Unknown country [AA]');

		$country = new Country('AA');
	}

	public function testBadCountry3()
	{
		$this->expectException('SynergyWholesale\Exception\UnknownCountryException', 'Unknown country [AUS]');

		$country = new Country('AUS');
	}

	public function testCountry()
	{
		$country = new Country('au');
		$this->assertEquals('AU', $country->getCountryCode());

		$country = new Country('AU');
		$this->assertEquals('AU', $country->getCountryCode());
		$this->assertEquals('Australia', $country->getCountryName());
	}
}
