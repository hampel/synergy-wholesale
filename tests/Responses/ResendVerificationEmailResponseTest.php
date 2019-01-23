<?php  namespace SynergyWholesale\Responses;

use stdClass;
use PHPUnit\Framework\TestCase;

class ResendVerificationEmailResponseTest extends TestCase
{
	public function testResponse()
	{
		$data = new stdClass;
		$data->status = "OK";

		$response = new ResendVerificationEmailResponse($data, 'ResendVerificationEmailCommand');

		$this->assertTrue($response->resendSuccessful());
	}
}
