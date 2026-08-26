<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Tests\Transport;

use Closure;
use Hampel\SynergyWholesale\Transport\SoapTransport;
use Hampel\SynergyWholesale\Transport\TransportException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;
use SoapClient;
use SoapFault;

/**
 * The transport is the one class that talks to the network, so it is the one
 * class a fixture cannot stand in for. It is still testable offline: a
 * non-WSDL SoapClient constructs without a request -- which is the whole
 * reason this package uses non-WSDL mode -- so a subclass overriding
 * __soapCall can produce a fault, or a non-object, without anything leaving
 * the machine.
 */
final class SoapTransportTest extends TestCase
{
    #[Test]
    public function it_returns_the_response_object_unchanged(): void
    {
        $response = (object) ['status' => 'OK', 'balance' => '12.34'];

        $transport = new SoapTransport(self::client(fn (): object => $response));

        $this->assertSame($response, $transport->call('balanceQuery', []));
    }

    #[Test]
    public function it_passes_the_request_as_a_single_argument(): void
    {
        $seen = null;

        $transport = new SoapTransport(self::client(function (string $name, array $args) use (&$seen): object {
            $seen = [$name, $args];

            return (object) [];
        }));

        $transport->call('checkDomain', ['domainName' => 'example.com']);

        // The API takes one struct, not a positional parameter list: everything
        // goes inside args[0]. Getting this wrong produces an empty request
        // that the server answers with a generic error.
        $this->assertSame(['checkDomain', [['domainName' => 'example.com']]], $seen);
    }

    #[Test]
    public function a_soap_fault_becomes_a_transport_exception_carrying_the_fault_code(): void
    {
        $transport = new SoapTransport(self::client(
            fn (): object => throw new SoapFault('HTTP', 'Could not connect to host'),
        ));

        try {
            $transport->call('balanceQuery', []);
            $this->fail('Expected a TransportException');
        } catch (TransportException $e) {
            $this->assertStringContainsString('balanceQuery', $e->getMessage());
            $this->assertStringContainsString('Could not connect to host', $e->getMessage());
            $this->assertSame('balanceQuery', $e->operation);
            // The fault code is what separates a transport failure from the
            // server declining, so it has to survive the wrap.
            $this->assertSame('HTTP', $e->faultCode);
            $this->assertInstanceOf(SoapFault::class, $e->getPrevious());
        }
    }

    #[Test]
    public function a_response_that_is_not_an_object_is_rejected_rather_than_returned(): void
    {
        // Non-WSDL mode gives SoapClient no schema to check the reply against,
        // so a body it cannot decode into a struct arrives as a scalar. Every
        // caller above here assumes an object.
        $transport = new SoapTransport(self::client(fn (): string => '<html>502 Bad Gateway</html>'));

        $this->expectException(TransportException::class);
        $this->expectExceptionMessage('Expected an object from [balanceQuery], got string');

        $transport->call('balanceQuery', []);
    }

    #[Test]
    public function make_defaults_to_the_published_endpoint(): void
    {
        $this->assertSame(SoapTransport::WSDL_URL, $this->locationOf(SoapTransport::make()));
    }

    #[Test]
    public function make_lets_the_caller_override_the_defaults(): void
    {
        // The options are merged as $options + [defaults], so the caller wins.
        // Reversing that would silently ignore a location, which is exactly
        // what a sandbox or a recording proxy would be passing.
        $transport = SoapTransport::make(['location' => 'https://sandbox.example.test/']);

        $this->assertSame('https://sandbox.example.test/', $this->locationOf($transport));
    }

    /**
     * __setLocation returns the location it replaced, which is the only way to
     * read one back off a SoapClient. The client itself is private because
     * nothing in the runtime has any business reaching it.
     */
    private function locationOf(SoapTransport $transport): string
    {
        $client = (new ReflectionProperty(SoapTransport::class, 'client'))->getValue($transport);

        $this->assertInstanceOf(SoapClient::class, $client);

        return (string) $client->__setLocation('https://replaced.example.test/');
    }

    /**
     * A SoapClient that never reaches the network: __soapCall hands off to the
     * closure instead, which can return anything or throw.
     *
     * @param  Closure(string, array<mixed>): mixed  $answer
     */
    private static function client(Closure $answer): SoapClient
    {
        return new class (null, ['location' => 'https://example.test/', 'uri' => ''], $answer) extends SoapClient {
            /**
             * @param  array<string, mixed>  $options
             * @param  Closure(string, array<mixed>): mixed  $answer
             */
            public function __construct(?string $wsdl, array $options, private readonly Closure $answer)
            {
                parent::__construct($wsdl, $options);
            }

            /**
             * @param  array<mixed>  $args
             * @param  array<string, mixed>|null  $options
             * @param  array<mixed>|null  $outputHeaders
             */
            public function __soapCall($name, $args, $options = null, $inputHeaders = null, &$outputHeaders = null): mixed
            {
                return ($this->answer)($name, $args);
            }
        };
    }
}
