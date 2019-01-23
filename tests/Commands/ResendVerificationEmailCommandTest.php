<?php  namespace SynergyWholesale\Commands;

use PHPUnit\Framework\TestCase;
use SynergyWholesale\Types\Domain;

class ResendVerificationEmailCommandTest extends TestCase
{
	public function testCommand()
	{
		$command = new ResendVerificationEmailCommand(new Domain('example.com'));
		$build = $command->getRequestData();

		$this->assertTrue(is_array($build));
		$this->assertArrayHasKey('domainName', $build);
		$this->assertEquals('example.com', $build['domainName']);
	}
}
