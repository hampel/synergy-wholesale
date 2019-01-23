<?php namespace SynergyWholesale\Commands;

use PHPUnit\Framework\TestCase;

class BalanceQueryCommandTest extends TestCase
{
	public function testGetRequestData()
	{
		$command = new BalanceQueryCommand();
		$build = $command->getRequestData();

		$this->assertTrue(is_array($build));
		$this->assertTrue(empty($build));
	}
}
