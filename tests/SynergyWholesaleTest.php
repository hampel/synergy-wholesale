<?php namespace SynergyWholesale;

use Mockery as m;
use stdClass;
use PHPUnit\Framework\TestCase;

class SynergyWholesaleTest extends TestCase
{
	use \Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

	protected $client;

	protected $command;

	protected $responseGenerator;

	protected $response;

	public function setUp() : void
	{
		$this->client = m::mock('SoapClient');

		$this->command = m::namedMock('FooCommand', 'SynergyWholesale\Commands\Command');
		$this->command->shouldReceive('getRequestData')->andReturn(array());

		$this->responseGenerator = m::mock('SynergyWholesale\ResponseGenerator');

		$this->response = m::mock('SynergyWholesale\Responses\Response');
	}

	public function testSoapException()
	{
		$this->client->shouldReceive('foo')->andThrow('SoapFault', '1');

		$this->expectException('SynergyWholesale\Exception\SoapException');

		$sw = new SynergyWholesale($this->client, $this->responseGenerator, null, "reseller_id", "api_key");
		$sw->execute($this->command);
	}

	public function testNullResponseException()
	{
		$this->client->shouldReceive('foo')->andReturn(null);

		$this->expectException('SynergyWholesale\Exception\BadDataException', 'Empty response received');

		$sw = new SynergyWholesale($this->client, $this->responseGenerator, null, "reseller_id", "api_key");
		$sw->execute($this->command);
	}

	public function testEmptyResponseException()
	{
		$this->client->shouldReceive('foo')->andReturn("");

		$this->expectException('SynergyWholesale\Exception\BadDataException', 'Empty response received');

		$sw = new SynergyWholesale($this->client, $this->responseGenerator, null, "reseller_id", "api_key");
		$sw->execute($this->command);
	}

	public function testWrongObjectResponseException()
	{
		$otherobject = m::mock();

		$this->client->shouldReceive('foo')->andReturn($otherobject);

		$this->expectException('SynergyWholesale\Exception\BadDataException', 'Expected a stdClass response from Soap command [foo]');

		$sw = new SynergyWholesale($this->client, $this->responseGenerator, null, "reseller_id", "api_key");
		$sw->execute($this->command);
	}

	public function testExecute()
	{
		$testResponse = new stdClass();
		$testResponse->status = "OK";

		$this->client->shouldReceive('foo')->andReturn($testResponse);
		$this->responseGenerator->shouldReceive('buildResponse')->with('FooCommand', $testResponse, 'foo')->andReturn($this->response);

		$sw = new SynergyWholesale($this->client, $this->responseGenerator, null, "reseller_id", "api_key");
		$response = $sw->execute($this->command);

		$this->assertInstanceOf('SynergyWholesale\Responses\Response', $response);
	}
}

