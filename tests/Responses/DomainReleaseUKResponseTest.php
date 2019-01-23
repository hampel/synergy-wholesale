<?php  namespace SynergyWholesale\Responses;

use stdClass;
use PHPUnit\Framework\TestCase;

class DomainReleaseUKResponseTest extends TestCase
{
	public function testResponse()
	{
		$data = new stdClass;
		$data->status = "OK";

		$response = new DomainReleaseUKResponse($data, 'DomainReleaseUKCommand');

		$this->assertTrue($response->updateSuccessful());
	}
}
