<?php  namespace SynergyWholesale\Types;

use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase {

	public function testBadEmail1()
	{
		$this->expectException('SynergyWholesale\Exception\InvalidArgumentException');
		$this->expectExceptionMessage('Invalid email address []');

		new Email('');
	}

	public function testBadEmail2()
	{
		$this->expectException('SynergyWholesale\Exception\InvalidArgumentException');
		$this->expectExceptionMessage('Invalid email address [foo@example]');

		new Email('foo@example');
	}

	public function testEmail()
	{
		$email = new Email('foo@example.com');
		$this->assertEquals('foo@example.com', $email->getEmail());
	}
}
