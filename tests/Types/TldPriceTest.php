<?php  namespace SynergyWholesale\Types;

use PHPUnit\Framework\TestCase;

class TldPriceTest extends TestCase {

	public function testBadTldPriceMinPeriodRequired()
	{
		$this->expectException('SynergyWholesale\Exception\InvalidArgumentException');
		$this->expectExceptionMessage('minPeriod parameter is required');

		new TldPrice(
			new Tld('foo'),
			0,
			0,
			'',
			'',
			'',
			[]
		);
	}

	public function testBadTldPriceMaxPeriodRequired()
	{
		$this->expectException('SynergyWholesale\Exception\InvalidArgumentException');
		$this->expectExceptionMessage('maxPeriod parameter is required');

		new TldPrice(
			new Tld('foo'),
			1,
			0,
			'',
			'',
			'',
			[]
		);
	}

	public function testBadTldPriceMaxPeriodLess()
	{
		$this->expectException('SynergyWholesale\Exception\InvalidArgumentException');
		$this->expectExceptionMessage('maxPeriod should not be less than minPeriod');

		new TldPrice(
			new Tld('foo'),
			2,
			1,
			'',
			'',
			'',
			[]
		);
	}

	public function testBadTldPriceTransferNumeric()
	{
		$this->expectException('SynergyWholesale\Exception\InvalidArgumentException');
		$this->expectExceptionMessage('transfer should be numeric');

		new TldPrice(
			new Tld('foo'),
			1,
			1,
			'',
			'',
			'',
			[]
		);
	}

	public function testBadTldPriceRenewNumeric()
	{
		$this->expectException('SynergyWholesale\Exception\InvalidArgumentException');
		$this->expectExceptionMessage('renew should be numeric');

		new TldPrice(
			new Tld('foo'),
			1,
			1,
			'1',
			'',
			'',
			[]
		);
	}

	public function testBadTldPriceRedemptionNumeric()
	{
		$this->expectException('SynergyWholesale\Exception\InvalidArgumentException');
		$this->expectExceptionMessage('redemption should be numeric');

		new TldPrice(
			new Tld('foo'),
			1,
			1,
			'1',
			'1',
			'',
			[]
		);
	}

	public function testBadTldPriceRegisterIndex()
	{
		$this->expectException('SynergyWholesale\Exception\InvalidArgumentException');
		$this->expectExceptionMessage('register year must not be less than 1');

		new TldPrice(
			new Tld('foo'),
			1,
			1,
			'1',
			'1',
			null,
			[0 => '0']
		);
	}

	public function testBadTldPriceRegisterIndexMax()
	{
		$this->expectException('SynergyWholesale\Exception\InvalidArgumentException');
		$this->expectExceptionMessage('register year must not be more than 1');

		new TldPrice(
			new Tld('foo'),
			1,
			1,
			'1',
			'1',
			null,
			[
				1 => '1',
				2 => '2'
			]
		);
	}


	public function testTldPrice()
	{
		$price = new TldPrice(
			new Tld('foo'),
			1,
			2,
			'3',
			'4.0',
			null,
			[
				1 => '5.00',
				2 => '6',
			]
		);

		$this->assertEquals('foo', $price->getTld()->getTld());
		$this->assertEquals(1, $price->getMinPeriod());
		$this->assertEquals(2, $price->getMaxPeriod());
		$this->assertEquals("3", $price->getTransfer());
		$this->assertEquals("4.0", $price->getRenew());
		$this->assertNull($price->getRedemption());
		$this->assertTrue(is_array($price->getRegister()));
		$this->assertEquals(2, count($price->getRegister()));
		$this->assertArrayHasKey(1, $price->getRegister());
		$this->assertArrayHasKey(2, $price->getRegister());
		$this->assertEquals('5.00', $price->getRegister()[1]);
		$this->assertEquals('6', $price->getRegister()[2]);
	}
}
