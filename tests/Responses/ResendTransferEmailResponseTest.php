<?php  namespace SynergyWholesale\Responses;

use stdClass;
use PHPUnit\Framework\TestCase;

class ResendTransferEmailResponseTest extends TestCase
{
	public function testMissingEmail()
	{
		$data = new stdClass();
		$data->status = "OK";

		$this->expectException('SynergyWholesale\Exception\BadDataException');
		$this->expectExceptionMessage('Expected property [newEmail] missing from response data');

		new ResendTransferEmailResponse($data, 'ResendTransferEmailCommand');
	}

	public function testBadEmail()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->newEmail = 'foo';

		$this->expectException('SynergyWholesale\Exception\BadDataException');
		$this->expectExceptionMessage('Response parameter newEmail should contain an email address');

		new ResendTransferEmailResponse($data, 'ResendTransferEmailCommand');
	}

	public function testResponse()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->newEmail = 'foo@example.com';

		$response = new ResendTransferEmailResponse($data, 'ResendTransferEmailCommand');

		$this->assertEquals('foo@example.com', $response->getNewEmail());
	}
}
