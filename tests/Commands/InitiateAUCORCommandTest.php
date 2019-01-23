<?php  namespace SynergyWholesale\Commands;

use PHPUnit\Framework\TestCase;
use SynergyWholesale\Types\AuDomain;

class InitiateAUCORCommandTest extends TestCase
{
	public function testCommand()
	{
		$command = new InitiateAUCORCommand(new AuDomain('example.com.au'));
		$build = $command->getRequestData();

		$this->assertTrue(is_array($build));
		$this->assertArrayHasKey('domainName', $build);
		$this->assertEquals('example.com.au', $build['domainName']);
	}
}
