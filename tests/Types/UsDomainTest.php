<?php  namespace SynergyWholesale\Types;

use PHPUnit\Framework\TestCase;

class UsDomainTest extends TestCase
{
	public function testBadDomain()
	{
		$this->expectException('SynergyWholesale\Exception\InvalidArgumentException');
		$this->expectExceptionMessage('Invalid domain name [example.com] - must be a .us domain');

		new UsDomain('example.com');
	}

	public function testDomain()
	{
		$domain = new UsDomain('example.us');

		$this->assertEquals('example.us', $domain->getName());
		$this->assertEquals('example.us', strval($domain));
		$this->assertEquals('us', $domain->getTld());
		$this->assertEquals('us', $domain->getExtension());
		$this->assertEquals('example', $domain->getBaseName());
		$this->assertTrue($domain->isCcTld());
		$this->assertFalse($domain->is2ld());
		$this->assertFalse($domain->isSubDomain());

		$domain = new UsDomain('www.example.us');
		$this->assertTrue($domain->isSubDomain());
	}
}
