<?php  namespace SynergyWholesale\Responses;

use stdClass;
use PHPUnit\Framework\TestCase;

class UpdateNameServersResponseTest extends TestCase
{
	public function testResponse()
	{
		$data = new stdClass;
		$data->status = "OK";

		$response = new UpdateNameServersResponse($data, 'UpdateNameServersCommand');

		$this->assertTrue($response->updateSuccessful());
	}
}
