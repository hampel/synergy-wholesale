<?php  namespace SynergyWholesale\Commands;

use SynergyWholesale\Types\AuDomain;

class _InitiateAUCORCommandTest extends \PHPUnit_Framework_TestCase
{
	public function testCommand()
	{
		$command = new _InitiateAUCORCommand(new AuDomain('example.com.au'));
		$build = $command->getRequestData();

		$this->assertTrue(is_array($build));
		$this->assertArrayHasKey('domainName', $build);
		$this->assertEquals('example.com.au', $build['domainName']);
	}
}
