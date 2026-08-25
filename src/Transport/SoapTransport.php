<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Transport;

use SoapClient;
use SoapFault;
use stdClass;

/**
 * The real transport: PHP's SoapClient in non-WSDL mode.
 *
 * Non-WSDL mode is deliberate. The WSDL is 275KB and parsing it on every boot
 * to learn what this package already knows at build time would be a needless
 * cost on every request. The WSDL's authority is exercised by the generator
 * instead, once, at the point the typed surface is produced.
 */
final class SoapTransport implements Transport
{
    public const WSDL_URL = 'https://api.synergywholesale.com/?wsdl';

    public function __construct(private readonly SoapClient $client)
    {
    }

    /**
     * @param  array<string, mixed>  $options passed to the SoapClient constructor
     */
    public static function make(array $options = []): self
    {
        return new self(new SoapClient(null, $options + [
            'location' => self::WSDL_URL,
            'uri' => '',
            'exceptions' => true,
        ]));
    }

    public function call(string $operation, array $request): object
    {
        try {
            /** @var mixed $response */
            $response = $this->client->__soapCall($operation, [$request]);
        } catch (SoapFault $e) {
            throw new TransportException(
                "SOAP call [{$operation}] failed: {$e->getMessage()}",
                $operation,
                $e->faultcode ?? null,
                $e,
            );
        }

        if (! $response instanceof stdClass) {
            throw new TransportException(
                sprintf('Expected an object from [%s], got %s', $operation, get_debug_type($response)),
                $operation,
            );
        }

        return $response;
    }
}
