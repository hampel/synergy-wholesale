<?php  namespace SynergyWholesale\Responses;

use stdClass;

class EnableIDProtectionResponseTest extends \PHPUnit_Framework_TestCase
{
	public function testResponse()
	{
		$data = new stdClass;
		$data->status = "OK";

		$response = new EnableIDProtectionResponse($data, 'EnableIdProtectionCommand');

		$this->assertTrue($response->enableSuccessful());
	}
}
