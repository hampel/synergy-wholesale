<?php  namespace SynergyWholesale\Commands;

use PHPUnit\Framework\TestCase;
use SynergyWholesale\Types\UkDomain;

class DomainTransferUKCommandTest extends TestCase
{
	public function testCommand()
	{
		$command = new DomainTransferUKCommand(new UkDomain('example.uk'));
		$build = $command->getRequestData();

		$this->assertTrue(is_array($build));
		$this->assertArrayHasKey('domainName', $build);
		$this->assertEquals('example.uk', $build['domainName']);
	}
}
