<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Transport;

/**
 * The seam between this client and the network.
 *
 * Everything above this interface is pure data transformation and can be
 * tested without a socket; everything below it is one small class. The v1
 * package had no such seam -- it constructed a SoapClient itself -- so its
 * tests could only reach the wire through a Mockery mock of a concrete class,
 * and no test could cover a real response shape.
 */
interface Transport
{
    /**
     * Calls one API operation and returns the raw response object.
     *
     * Implementations deal with transport failure only. Whether the response
     * represents an application-level error is decided by the envelope, above.
     *
     * @param  array<string, mixed>  $request
     *
     * @throws TransportException when the call cannot be completed at all
     */
    public function call(string $operation, array $request): object;
}
