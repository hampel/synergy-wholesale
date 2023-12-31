<?php  namespace SynergyWholesale\Commands; 

use PHPUnit\Framework\TestCase;
use SynergyWholesale\Types\UsDomain;

class GetUSNexusDataTest extends TestCase
{
	public function testCommand()
	{
		$command = new GetUSNexusDataCommand(new UsDomain('example.us'));
		$build = $command->getRequestData();

		$this->assertTrue(is_array($build));
		$this->assertArrayHasKey('domainName', $build);
		$this->assertEquals('example.us', $build['domainName']);
	}
}
