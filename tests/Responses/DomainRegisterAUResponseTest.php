<?php  namespace SynergyWholesale\Responses;

use stdClass;
use PHPUnit\Framework\TestCase;

class DomainRegisterAUResponseTest extends TestCase
{
	public function testMissingCostPrice()
	{
		$data = new stdClass();
		$data->status = "OK";

		$this->expectException('SynergyWholesale\Exception\BadDataException');
		$this->expectExceptionMessage('Expected property [costPrice] missing from response data');

		new DomainRegisterAUResponse($data, 'DomainRegisterAUCommand');
	}

	public function testBadCostPrice()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->costPrice = "foo";

		$this->expectException('SynergyWholesale\Exception\BadDataException');
		$this->expectExceptionMessage('Expected a numeric cost price');

		new DomainRegisterAUResponse($data, 'DomainRegisterAUCommand');
	}

	public function testResponse()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->costPrice = "10.00";

		$response = new DomainRegisterAUResponse($data, 'DomainRegisterAUCommand');
		$this->assertEquals('10.00', $response->getCostPrice());
	}
}
