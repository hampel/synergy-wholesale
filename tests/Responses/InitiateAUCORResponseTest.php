<?php  namespace SynergyWholesale\Responses;

use stdClass;
use PHPUnit\Framework\TestCase;

class InitiateAUCORResponseTest extends TestCase
{
	public function testMissingCostPrice()
	{
		$data = new stdClass();
		$data->status = "OK";

		$this->expectException('SynergyWholesale\Exception\BadDataException');
		$this->expectExceptionMessage('Expected property [costPrice] missing from response data');

		new InitiateAUCORResponse($data, 'InitiateAuCorCommand');
	}

	public function testBadCostPrice()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->costPrice = "foo";

		$this->expectException('SynergyWholesale\Exception\BadDataException');
		$this->expectExceptionMessage('Expected a numeric cost price');

		new InitiateAUCORResponse($data, 'InitiateAuCorCommand');
	}

	public function testResponse()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->costPrice = "10.00";

		$response = new InitiateAUCORResponse($data, 'InitiateAuCorCommand');
		$this->assertEquals('10.00', $response->getCostPrice());
	}
}
