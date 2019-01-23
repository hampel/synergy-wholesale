<?php  namespace SynergyWholesale\Responses;

use stdClass;
use PHPUnit\Framework\TestCase;

class ResubmitFailedTransferResponseTest extends TestCase
{
	public function testMissingEmail()
	{
		$data = new stdClass();
		$data->status = "OK";

		$this->expectException('SynergyWholesale\Exception\BadDataException', 'Expected property [newEmail] missing from response data');

		new ResubmitFailedTransferResponse($data, 'ResubmitFailedTransferCommand');
	}

		public function testMissingCostPrice()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->newEmail = 'foo@example.com';

		$this->expectException('SynergyWholesale\Exception\BadDataException', 'Expected property [costPrice] missing from response data');

		new ResubmitFailedTransferResponse($data, 'ResubmitFailedTransferCommand');
	}

	public function testBadEmail()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->newEmail = 'foo';
		$data->costPrice = '';

		$this->expectException('SynergyWholesale\Exception\BadDataException', 'Response parameter newEmail should contain an email address');

		new ResubmitFailedTransferResponse($data, 'ResubmitFailedTransferCommand');
	}

	public function testResponse()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->newEmail = 'foo@example.com';
		$data->costPrice = '10.00';

		$response = new ResubmitFailedTransferResponse($data, 'ResubmitFailedTransferCommand');

		$this->assertEquals('foo@example.com', $response->getNewEmail());
		$this->assertEquals('10.00', $response->getCostPrice());
	}
}
