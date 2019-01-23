<?php  namespace SynergyWholesale\Commands;

use PHPUnit\Framework\TestCase;
use SynergyWholesale\Types\Domain;

class EnableAutoRenewalCommandTest extends TestCase
{
	public function testCommand()
	{
		$command = new EnableAutoRenewalCommand(new Domain('example.com'));
		$build = $command->getRequestData();

		$this->assertTrue(is_array($build));
		$this->assertArrayHasKey('domainName', $build);
		$this->assertEquals('example.com', $build['domainName']);
	}
}
