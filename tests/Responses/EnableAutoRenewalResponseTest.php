<?php  namespace SynergyWholesale\Responses;

use stdClass;
use PHPUnit\Framework\TestCase;

class EnableAutoRenewalResponseTest extends TestCase
{
	public function testResponse()
	{
		$data = new stdClass;
		$data->status = "OK";

		$response = new EnableAutoRenewalResponse($data, 'EnableAutoRenewalCommand');

		$this->assertTrue($response->enableSuccessful());
	}
}
