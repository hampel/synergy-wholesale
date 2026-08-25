<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Transport;

/**
 * An in-memory transport for tests: answers from a prepared map of responses
 * and records what it was asked.
 *
 * This is what the seam is for. A test can now assert on the exact request
 * that would have gone over the wire -- including that a null parameter was
 * omitted rather than sent -- without a mock of SoapClient and without a
 * network.
 */
final class FixtureTransport implements Transport
{
    /** @var list<array{operation: string, request: array<string, mixed>}> */
    public array $calls = [];

    /**
     * @param  array<string, object|callable(array<string, mixed>): object>  $responses
     *         keyed by operation name
     */
    public function __construct(private array $responses = [])
    {
    }

    /**
     * Builds a response object from an array, the shape the API returns.
     *
     * @param  array<string, mixed>  $fields
     */
    public static function response(array $fields): object
    {
        /** @var mixed $decoded */
        $decoded = json_decode(json_encode($fields, JSON_THROW_ON_ERROR), false, 512, JSON_THROW_ON_ERROR);

        if (! is_object($decoded)) {
            throw new TransportException('A fixture response must be an object', '(fixture)');
        }

        return $decoded;
    }

    /**
     * @param  object|callable(array<string, mixed>): object  $response
     */
    public function on(string $operation, object|callable $response): self
    {
        $this->responses[$operation] = $response;

        return $this;
    }

    public function call(string $operation, array $request): object
    {
        $this->calls[] = ['operation' => $operation, 'request' => $request];

        $response = $this->responses[$operation] ?? null;

        if ($response === null) {
            throw new TransportException(
                "No fixture registered for [{$operation}]",
                $operation,
            );
        }

        if (! is_callable($response)) {
            return $response;
        }

        /** @var mixed $result */
        $result = $response($request);

        if (! is_object($result)) {
            throw new TransportException("Fixture for [{$operation}] did not return an object", $operation);
        }

        return $result;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function lastRequest(?string $operation = null): ?array
    {
        foreach (array_reverse($this->calls) as $call) {
            if ($operation === null || $call['operation'] === $operation) {
                return $call['request'];
            }
        }

        return null;
    }
}
