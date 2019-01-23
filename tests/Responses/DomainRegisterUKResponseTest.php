<?php  namespace SynergyWholesale\Responses;

use stdClass;
use PHPUnit\Framework\TestCase;

class DomainRegisterUKResponseTest extends TestCase
{
	public function testMissingCostPrice()
	{
		$data = new stdClass();
		$data->status = "OK";

		$this->expectException('SynergyWholesale\Exception\BadDataException', 'Expected property [costPrice] missing from response data');

		new DomainRegisterUKResponse($data, 'DomainRegisterUKCommand');
	}

	public function testBadCostPrice()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->costPrice = "foo";

		$this->expectException('SynergyWholesale\Exception\BadDataException', 'Expected a numeric cost price');

		new DomainRegisterUKResponse($data, 'DomainRegisterUKCommand');
	}

	public function testResponse()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->costPrice = "10.00";

		$response = new DomainRegisterUKResponse($data, 'DomainRegisterUKCommand');
		$this->assertEquals('10.00', $response->getCostPrice());
	}
}
