<?php namespace SynergyWholesale\Commands;

use PHPUnit\Framework\TestCase;

class GetDomainPricingCommandTest extends TestCase
{
	public function testGetRequestData()
	{
		$command = new GetDomainPricingCommand();
		$build = $command->getRequestData();

		$this->assertTrue(is_array($build));
		$this->assertTrue(empty($build));
	}
}
