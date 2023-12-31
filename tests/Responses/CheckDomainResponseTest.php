<?php  namespace SynergyWholesale\Responses;

use stdClass;
use PHPUnit\Framework\TestCase;

class CheckDomainResponseTest extends TestCase
{
	public function testResponse()
	{
		$data = new stdClass();
		$data->status = "AVAILABLE";

		$response = new CheckDomainResponse($data, 'CheckDomainCommand');

		$this->assertEquals(true, $response->isAvailable());
	}

	public function testResponse2()
	{
		$data = new stdClass();
		$data->status = "UNAVAILABLE";

		$response = new CheckDomainResponse($data, 'CheckDomainCommand');

		$this->assertEquals(false, $response->isAvailable());
	}
}
