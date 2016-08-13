<?php namespace SynergyWholesale\Commands;

class GetDomainPricingCommandTest extends \PHPUnit_Framework_TestCase
{
	public function testGetRequestData()
	{
		$command = new GetDomainPricingCommand();
		$build = $command->getRequestData();

		$this->assertTrue(is_array($build));
		$this->assertTrue(empty($build));
	}
}
