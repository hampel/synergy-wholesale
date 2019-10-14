<?php  namespace SynergyWholesale\Responses;

use stdClass;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase {

	public function testEmptyObjectException()
	{
		$data = new stdClass();

		$this->expectException('SynergyWholesale\Exception\BadDataException', 'No status found in response to Soap command [foo]');

		new FooBarResponse($data, 'foo');
	}

	public function testDataException()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->foo = "bar";

		$this->expectException('SynergyWholesale\Exception\BadDataException', 'Expected property [bar] missing from response data');

		new FooBarResponse($data, 'foo');
	}

	public function testErrorException()
	{
		$data = new stdClass();
		$data->status = "NOT_OK";
		$data->errorMessage = "FooBar";

		$this->expectException('SynergyWholesale\Exception\ResponseErrorException', 'FooBar');

		new FooBarResponse($data, 'foo');
	}

	public function testResponse()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->foo = "bar";
		$data->bar = "foo";

		$response = new FooBarResponse($data, 'foo');

		$this->assertInstanceOf('SynergyWholesale\Responses\FooBarResponse', $response);

		$responseData = $response->getRawResponse();
		$this->assertTrue(isset($responseData));
		$this->assertInstanceOf('stdClass', $responseData);
		$this->assertTrue(isset($responseData->status));
		$this->assertEquals('OK', $responseData->status);
		$this->assertTrue(isset($responseData->foo));
		$this->assertEquals('bar', $responseData->foo);
	}
}

class FooBarResponse extends Response
{
	protected $expectedFields = array('foo', 'bar');

	public function validateData(){}
}
