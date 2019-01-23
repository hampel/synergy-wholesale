<?php  namespace SynergyWholesale\Responses;

use stdClass;
use PHPUnit\Framework\TestCase;

class UpdateContactResponseTest extends TestCase
{
	public function testResponse()
	{
		$data = new stdClass;
		$data->status = "OK";

		$response = new UpdateContactResponse($data, 'UpdateContactCommand');

		$this->assertTrue($response->updateSuccessful());
	}
}
