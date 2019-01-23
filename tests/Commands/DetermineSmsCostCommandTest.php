<?php  namespace SynergyWholesale\Commands;

use PHPUnit\Framework\TestCase;

class DetermineSMSCostCommandTest extends TestCase
{
	public function testCommand()
	{
		$command = new DetermineSMSCostCommand(
			'0400000000',
			'foo'
		);

		$build = $command->getRequestData();

		$this->assertTrue(is_array($build));
		$this->assertArrayHasKey('destination', $build);
		$this->assertEquals('0400000000', $build['destination']);
		$this->assertArrayHasKey('message', $build);
		$this->assertEquals('foo', $build['message']);
	}
}
