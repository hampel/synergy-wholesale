<?php  namespace SynergyWholesale\Types; 

use PHPUnit\Framework\TestCase;

class AuPostCodeTest extends TestCase
{
	public function testBadPostCode1()
	{
		$this->expectException('SynergyWholesale\Exception\InvalidArgumentException', 'Invalid postcode []');

		$postcode = new AuPostCode('');
	}

	public function testBadPostCode2()
	{
		$this->expectException('SynergyWholesale\Exception\InvalidArgumentException', 'Invalid postcode [0]');

		$postcode = new AuPostCode(0);
	}

	public function testBadPostCode3()
	{
		$this->expectException('SynergyWholesale\Exception\InvalidArgumentException', 'Invalid postcode [0]');

		$postcode = new AuPostCode(0000);
	}

	public function testBadPostCode4()
	{
		$this->expectException('SynergyWholesale\Exception\InvalidArgumentException', 'Invalid postcode [10000]');

		$postcode = new AuPostCode(10000);
	}

	public function testBadPostCode5()
	{
		$this->expectException('SynergyWholesale\Exception\InvalidArgumentException', 'Invalid postcode [1.111]');

		$postcode = new AuPostCode(1.111);
	}

	public function testBadPostCode6()
	{
		$this->expectException('SynergyWholesale\Exception\InvalidArgumentException', 'Invalid postcode [00000]');

		$postcode = new AuPostCode("00000");
	}

	public function testBadPostCode7()
	{
		$this->expectException('SynergyWholesale\Exception\InvalidArgumentException', 'Invalid postcode [0.000]');

		$postcode = new AuPostCode("0.000");
	}

	public function testPostcode()
	{
		$postcode = new AuPostCode(2000);
		$this->assertEquals('2000', $postcode->getPostcode());
		$this->assertEquals('2000', strval($postcode));
	}
}

