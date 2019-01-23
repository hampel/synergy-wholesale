<?php  namespace SynergyWholesale\Responses;

use stdClass;
use PHPUnit\Framework\TestCase;

class GetDomainPricingResponseTest extends TestCase
{
	public function testMissingBalance()
	{
		$data = new stdClass();
		$data->status = "OK";

		$this->expectException('SynergyWholesale\Exception\BadDataException', 'Expected property [pricing] missing from response data');

		new GetDomainPricingResponse($data, 'GetDomainPricingCommand');
	}

	public function testResponse()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->pricing = [];

		$response = new GetDomainPricingResponse($data, 'GetDomainPricingCommand');

		$this->assertTrue(is_array($response->getPricing()));
	}
}
