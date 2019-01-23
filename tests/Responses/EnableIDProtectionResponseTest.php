<?php  namespace SynergyWholesale\Responses;

use stdClass;
use PHPUnit\Framework\TestCase;

class EnableIDProtectionResponseTest extends TestCase
{
	public function testResponse()
	{
		$data = new stdClass;
		$data->status = "OK";

		$response = new EnableIDProtectionResponse($data, 'EnableIdProtectionCommand');

		$this->assertTrue($response->enableSuccessful());
	}
}
