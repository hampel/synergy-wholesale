<?php  namespace SynergyWholesale\Responses;

use stdClass;

class GetDomainPricingResponseTest extends \PHPUnit_Framework_TestCase
{
	public function testMissingBalance()
	{
		$data = new stdClass();
		$data->status = "OK";

		$this->setExpectedException('SynergyWholesale\Exception\BadDataException', 'Expected property [pricing] missing from response data');

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
