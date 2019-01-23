<?php  namespace SynergyWholesale\Commands;

use PHPUnit\Framework\TestCase;

class GetTransferredAwayDomainsCommandTest extends TestCase
{
	public function testGetRequestData()
	{
		$command = new GetTransferredAwayDomainsCommand();
		$build = $command->getRequestData();

		$this->assertTrue(is_array($build));
		$this->assertTrue(empty($build));
	}
}
