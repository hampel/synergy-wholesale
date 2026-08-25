<?php

/**
 * Not an exercise - see lib/agent.php for why files live down here.
 *
 * Keeps the raw response object for each call, so drift.php can compare what the API
 * actually sent against what the generated class declares.
 *
 * This exists because Wire is total by design: every helper returns null for a missing
 * field rather than raising, which is what stops one unexpected response breaking an
 * unrelated call. The cost is that a field the API sends and the generated class does not
 * declare is dropped in silence - no exception, no log line, no failing test. The wire
 * response is the only place that field is still visible, and by the time the API class
 * has hydrated its DTO it is gone.
 *
 * That this needs no change to the package is the point being demonstrated: the Transport
 * interface is the seam, and a decorator is what belongs there.
 */

use Hampel\SynergyWholesale\Transport\Transport;

final class RecordingTransport implements Transport
{
    /** @var array<string, object> keyed by operation, last call wins */
    public array $responses = [];

    public function __construct(private readonly Transport $inner)
    {
    }

    public function call(string $operation, array $request): object
    {
        $response = $this->inner->call($operation, $request);

        $this->responses[$operation] = $response;

        return $response;
    }
}
