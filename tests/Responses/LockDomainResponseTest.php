<?php  namespace SynergyWholesale\Responses;

use stdClass;
use PHPUnit\Framework\TestCase;

class LockDomainResponseTest extends TestCase
{
	public function testResponse()
	{
		$data = new stdClass;
		$data->status = "OK";

		$response = new LockDomainResponse($data, 'LockDomainCommand');

		$this->assertTrue($response->lockSuccessful());
	}
}
