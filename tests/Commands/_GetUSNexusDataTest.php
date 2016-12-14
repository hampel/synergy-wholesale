<?php  namespace SynergyWholesale\Commands; 

use SynergyWholesale\Types\UsDomain;

class _GetUSNexusDataTest extends \PHPUnit_Framework_TestCase
{
	public function testCommand()
	{
		$command = new _GetUSNexusDataCommand(new UsDomain('example.us'));
		$build = $command->getRequestData();

		$this->assertTrue(is_array($build));
		$this->assertArrayHasKey('domainName', $build);
		$this->assertEquals('example.us', $build['domainName']);
	}
}
