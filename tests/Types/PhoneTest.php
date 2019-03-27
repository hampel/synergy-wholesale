<?php  namespace SynergyWholesale\Types;

use PHPUnit\Framework\TestCase;

class PhoneTest extends TestCase {

	public function testBadPhoneEmpty()
	{
		$this->expectException('SynergyWholesale\Exception\InvalidArgumentException', 'Invalid phone number [] - must be in the format +99.999999999');

		$phone = new Phone('');
	}

	public function testBadPhoneWord()
	{
		$this->expectException('SynergyWholesale\Exception\InvalidArgumentException', 'Invalid phone number [] - must be in the format +99.999999999');

		$phone = new Phone('foo');
	}

	public function testBadPhoneTooShort()
	{
		$this->expectException('SynergyWholesale\Exception\InvalidArgumentException', 'Invalid phone number [+0.0] - must be in the format +99.999999999');

		$phone = new Phone('+0.0');
	}

	public function testBadPhoneTooLong()
	{
		$this->expectException('SynergyWholesale\Exception\InvalidArgumentException', 'Invalid phone number [+AA.AAAAAAAAA] - must be in the format +99.999999999');

		$phone = new Phone('+00.0000000000000');
	}

	public function testBadPhoneNonNumeric()
	{
		$this->expectException('SynergyWholesale\Exception\InvalidArgumentException', 'Invalid phone number [+AA.AAAAAAAAA] - must be in the format +99.999999999');

		$phone = new Phone('+AA.AAAAAAAAA');
	}

	public function testPhone()
	{
		$phone = new Phone('+00.000000000');
		$this->assertEquals('+00.000000000', $phone->getPhone());

		$phone = new Phone('+0.000000');
		$this->assertEquals('+0.000000', $phone->getPhone());

		// test space stripping
		$phone = new Phone('+00.0 0000 0000');
		$this->assertEquals('+00.000000000', $phone->getPhone());

		$phone = new Phone('+00.00000000000');
		$this->assertEquals('+00.00000000000', $phone->getPhone());
	}
}
