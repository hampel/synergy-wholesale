<?php  namespace SynergyWholesale\Responses;

use stdClass;

class _EnableIDProtectionResponseTest extends \PHPUnit_Framework_TestCase
{
	public function testResponse()
	{
		$data = new stdClass;
		$data->status = "OK";

		$response = new _EnableIDProtectionResponse($data, 'EnableIdProtectionCommand');

		$this->assertTrue($response->enableSuccessful());
	}
}
