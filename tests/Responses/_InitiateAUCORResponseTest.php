<?php  namespace SynergyWholesale\Responses;

use stdClass;

class _InitiateAUCORResponseTest extends \PHPUnit_Framework_TestCase
{
	public function testMissingCostPrice()
	{
		$data = new stdClass();
		$data->status = "OK";

		$this->setExpectedException('SynergyWholesale\Exception\BadDataException', 'Expected property [costPrice] missing from response data');

		new _InitiateAUCORResponse($data, 'InitiateAuCorCommand');
	}

	public function testBadCostPrice()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->costPrice = "foo";

		$this->setExpectedException('SynergyWholesale\Exception\BadDataException', 'Expected a numeric cost price');

		new _InitiateAUCORResponse($data, 'InitiateAuCorCommand');
	}

	public function testResponse()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->costPrice = "10.00";

		$response = new _InitiateAUCORResponse($data, 'InitiateAuCorCommand');
		$this->assertEquals('10.00', $response->getCostPrice());
	}
}
