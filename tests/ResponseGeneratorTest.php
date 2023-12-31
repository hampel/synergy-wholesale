<?php
namespace SynergyWholesale
{

	use stdClass;
	use PHPUnit\Framework\TestCase;

	class ResponseGeneratorTest extends TestCase
	{
		public function testSoapException()
		{
			$commandName = 'SynergyWholesale\Commands\FooCommand';

			$this->expectException('SynergyWholesale\Exception\ClassNotRegisteredException');
			$this->expectExceptionMessage('Response class [SynergyWholesale\Responses\FooResponse] does not exist');

			$rg = new BasicResponseGenerator();
			$rg->buildResponse($commandName, new StdClass(), 'foo');
		}

		public function testGenerator()
		{
			$commandName = 'SynergyWholesale\Commands\BarCommand';

			$rg = new BasicResponseGenerator();
			$response = $rg->buildResponse($commandName, new StdClass(), 'bar');

			$this->assertInstanceOf('SynergyWholesale\Responses\BarResponse', $response);
		}
	}
}

namespace SynergyWholesale\Commands
{
	class FooCommand
	{

	}

	class BarCommand
	{

	}
}

namespace SynergyWholesale\Responses
{
	class BarResponse
	{

	}
}
