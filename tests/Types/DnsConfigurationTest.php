<?php  namespace SynergyWholesale\Types;

use PHPUnit\Framework\TestCase;

class DnsConfigurationTest extends TestCase
{
	public function testUnknownConfig()
	{
		$this->expectException('SynergyWholesale\Exception\UnknownDnsConfigurationException', 'Unknown DNS Configuration [foo]');

		new DnsConfiguration('foo');
	}

	public function testDnsConfig()
	{
		$config = new DnsConfiguration(1);

		$this->assertEquals(1, $config->getConfig());
		$this->assertEquals(1, strval($config));
		$this->assertEquals(DnsConfiguration::CUSTOM_NAME_SERVERS, strval($config));
		$this->assertTrue($config->equals(DnsConfiguration::CUSTOM()));
	}
}
