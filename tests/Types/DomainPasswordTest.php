<?php  namespace SynergyWholesale\Types;

use PHPUnit\Framework\TestCase;

class DomainPasswordTest extends TestCase
{
	public function testShortPassword()
	{
		$this->expectException('SynergyWholesale\Exception\LengthException', 'Domain passwords should contain between 6 and 16 characters');

		$password = new DomainPassword('');
	}

	public function testLongPassword()
	{
		$this->expectException('SynergyWholesale\Exception\LengthException', 'Domain passwords should contain between 6 and 16 characters');

		$password = new DomainPassword('012345678901234567');
	}

	public function testPassword()
	{
		$password = new DomainPassword('foobar');

		$this->assertEquals('foobar', $password->getPassword());
	}
}
