<?php  namespace SynergyWholesale\Responses;

use stdClass;
use PHPUnit\Framework\TestCase;

class UnlockDomainResponseTest extends TestCase
{
	public function testResponse()
	{
		$data = new stdClass;
		$data->status = "OK";

		$response = new UnlockDomainResponse($data, 'UnlockDomainCommand');

		$this->assertTrue($response->unlockSuccessful());
	}
}
