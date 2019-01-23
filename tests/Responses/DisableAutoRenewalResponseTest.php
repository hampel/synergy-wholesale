<?php  namespace SynergyWholesale\Responses;

use stdClass;
use PHPUnit\Framework\TestCase;

class DisableAutoRenewalResponseTest extends TestCase
{
	public function testResponse()
	{
		$data = new stdClass;
		$data->status = "OK";

		$response = new DisableAutoRenewalResponse($data, 'DisableAutoRenewalCommand');

		$this->assertTrue($response->disableSuccessful());
	}
}
