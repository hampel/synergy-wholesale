<?php  namespace SynergyWholesale\Types;

use PHPUnit\Framework\TestCase;

class UsAppPurposeTest extends TestCase
{
	public function testBadAppPurpose()
	{
		$this->expectException('SynergyWholesale\Exception\UnknownAppPurposeException');
		$this->expectExceptionMessage('Unknown app purpose [foo]');

		new UsAppPurpose('foo');
	}

	public function testUsAppPurpose()
	{
		$ap = new UsAppPurpose('P1');
		$this->assertEquals('P1', $ap->getAppPurpose());
		$this->assertEquals('P1', strval($ap));
		$this->assertEquals(UsAppPurpose::BUSINESS_FOR_PROFIT, strval($ap));
		$this->assertTrue($ap->equals(UsAppPurpose::BUSINESS()));
	}
}
