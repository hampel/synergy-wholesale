<?php  namespace SynergyWholesale\Types;

use PHPUnit\Framework\TestCase;

class AuIdTypeTest extends TestCase
{
	public function testBadType()
	{
		$this->expectException('SynergyWholesale\Exception\UnknownIdTypeException');
		$this->expectExceptionMessage('Unknown id type [foo]');

		new AuIdType('foo');
	}

	public function testIdType()
	{
		$id = new AuIdType('ABN');
		$this->assertEquals('ABN', $id->getIdType());
		$this->assertEquals('ABN', strval($id));
		$this->assertTrue($id->equals(AuIdType::ABN()));

		$id = AuIdType::ACN();
		$this->assertEquals('ACN', $id->getIdType());
		$this->assertFalse($id->equals(AuIdType::ABN()));

		$id = AuIdType::OTHER();
		$this->assertEquals('OTHER', $id->getIdType());

		$state = new AuState('NSW');
		$id = AuIdType::createFromState($state);
		$this->assertEquals('NSW BN', $id->getIdType());
	}
}
