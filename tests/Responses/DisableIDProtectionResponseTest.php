<?php  namespace SynergyWholesale\Responses;

use stdClass;
use PHPUnit\Framework\TestCase;

class DisableIDProtectionResponseTest extends TestCase
{
	public function testResponse()
	{
		$data = new stdClass;
		$data->status = "OK";

		$response = new DisableIDProtectionResponse($data, 'DisableIdProtectionCommand');

		$this->assertTrue($response->disableSuccessful());
	}
}
