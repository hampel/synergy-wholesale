<?php  namespace SynergyWholesale\Responses;

use stdClass;
use PHPUnit\Framework\TestCase;

class BalanceQueryResponseTest extends TestCase
{
	public function testMissingBalance()
	{
		$data = new stdClass();
		$data->status = "OK";

		$this->expectException('SynergyWholesale\Exception\BadDataException');
		$this->expectExceptionMessage('Expected property [balance] missing from response data');

		new BalanceQueryResponse($data, 'BalanceQueryCommand');
	}

	public function testResponse()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->balance = 100;

		$response = new BalanceQueryResponse($data, 'BalanceQueryCommand');

		$this->assertEquals(100, $response->getBalance());
	}
}
