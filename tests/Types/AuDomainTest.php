<?php  namespace SynergyWholesale\Types;

use PHPUnit\Framework\TestCase;

class AuDomainTest extends TestCase {

	public function testBadDomain()
	{
		$this->expectException('SynergyWholesale\Exception\InvalidArgumentException');
		$this->expectExceptionMessage('Invalid domain name [example.com] - must be a .au domain');

		new AuDomain('example.com');
	}

	public function testDomain()
	{
		$domain = new AuDomain('example.com.au');

		$this->assertEquals('example.com.au', $domain->getName());
		$this->assertEquals('example.com.au', strval($domain));
		$this->assertEquals('au', $domain->getTld());
		$this->assertEquals('com.au', $domain->getExtension());
		$this->assertEquals('example', $domain->getBaseName());
		$this->assertTrue($domain->isCcTld());
		$this->assertTrue($domain->is2ld());
		$this->assertFalse($domain->isSubDomain());

		$domain = new AuDomain('www.example.net.au');

		$this->assertEquals('www.example.net.au', $domain->getName());
		$this->assertEquals('www.example.net.au', strval($domain));
		$this->assertEquals('au', $domain->getTld());
		$this->assertEquals('net.au', $domain->getExtension());
		$this->assertEquals('example', $domain->getBaseName());
		$this->assertTrue($domain->isCcTld());
		$this->assertTrue($domain->is2ld());
		$this->assertTrue($domain->isSubDomain());
	}
}
