<?php  namespace SynergyWholesale\Responses;

use stdClass;
use PHPUnit\Framework\TestCase;

class UpdateDomainPasswordResponseTest extends TestCase
{
	public function testResponse()
	{
		$data = new stdClass;
		$data->status = "OK";

		$response = new UpdateDomainPasswordResponse($data, 'UpdateDomainPasswordCommand');

		$this->assertTrue($response->updateSuccessful());
	}
}
