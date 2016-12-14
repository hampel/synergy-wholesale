<?php  namespace SynergyWholesale\Responses;

use stdClass;

class _DisableIDProtectionResponseTest extends \PHPUnit_Framework_TestCase
{
	public function testResponse()
	{
		$data = new stdClass;
		$data->status = "OK";

		$response = new _DisableIDProtectionResponse($data, 'DisableIdProtectionCommand');

		$this->assertTrue($response->disableSuccessful());
	}
}
