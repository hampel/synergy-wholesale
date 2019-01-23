<?php  namespace SynergyWholesale\Types;

use PHPUnit\Framework\TestCase;

class AuOrganisationTypeTest extends TestCase
{
	public function testBadOrganisation()
	{
		$this->expectException('SynergyWholesale\Exception\UnknownOrganisationTypeException', 'Unknown organisation type [foo]');

		new AuOrganisationType('foo');
	}

	public function testOrganisation()
	{
		$org = new AuOrganisationType('Company');
		$this->assertEquals('Company', $org->getOrganisationType());
		$this->assertEquals('Company', strval($org));
		$this->assertTrue($org->isCompany());
		$this->assertFalse($org->isRegisteredBusiness());

		$org = new AuOrganisationType('Registered Business');
		$this->assertEquals('Registered Business', $org->getOrganisationType());
		$this->assertTrue($org->isRegisteredBusiness());
		$this->assertFalse($org->isCompany());
	}
}

