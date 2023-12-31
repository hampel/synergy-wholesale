<?php  namespace SynergyWholesale\Commands;

use PHPUnit\Framework\TestCase;
use SynergyWholesale\Types\Tld;

class GetDomainExtensionOptionsCommandTest extends TestCase
{
	public function testBadTld()
	{
		$this->expectException('SynergyWholesale\Exception\InvalidArgumentException');
		$this->expectExceptionMessage('Invalid Top Level Domain [example1]');

		new GetDomainExtensionOptionsCommand(new Tld('example1'));
	}

	public function testCommand()
	{
		$command = new GetDomainExtensionOptionsCommand(new Tld('.com.au'));
		$build = $command->getRequestData();

		$this->assertTrue(is_array($build));
		$this->assertArrayHasKey('tld', $build);
		$this->assertEquals('com.au', $build['tld']);
	}
}
