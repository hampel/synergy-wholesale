<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Tests;

use Hampel\SynergyWholesale\Client;
use Hampel\SynergyWholesale\Exception\ApiError;
use Hampel\SynergyWholesale\Transport\FixtureTransport;
use Hampel\SynergyWholesale\Transport\TransportException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Log\AbstractLogger;

final class ClientTest extends TestCase
{
    private function client(FixtureTransport $transport, ?AbstractLogger $logger = null): Client
    {
        return new Client($transport, 'reseller-1', 'secret-key', $logger);
    }

    #[Test]
    public function it_injects_credentials_into_every_request(): void
    {
        $transport = (new FixtureTransport())->on('checkDomain', FixtureTransport::response([
            'status' => 'AVAILABLE',
        ]));

        $this->client($transport)->call('checkDomain', ['domainName' => 'example.com']);

        $this->assertSame([
            'resellerID' => 'reseller-1',
            'apiKey' => 'secret-key',
            'domainName' => 'example.com',
        ], $transport->lastRequest());
    }

    #[Test]
    public function it_omits_null_parameters_rather_than_sending_them(): void
    {
        $transport = (new FixtureTransport())->on('checkDomain', FixtureTransport::response([
            'status' => 'AVAILABLE',
        ]));

        $this->client($transport)->call('checkDomain', [
            'domainName' => 'example.com',
            'years' => null,
            'command' => null,
        ]);

        $request = $transport->lastRequest() ?? [];

        $this->assertArrayNotHasKey('years', $request);
        $this->assertArrayNotHasKey('command', $request);
    }

    /**
     * The envelope rule is the whole of the error handling, so the values it
     * has to get right are worth pinning individually. AVAILABLE and
     * OK_NO_RENEWAL are the cases the v1 whitelist approach got wrong.
     */
    #[Test]
    #[DataProvider('successStatuses')]
    public function it_treats_any_non_err_status_as_success(string $status): void
    {
        $transport = (new FixtureTransport())->on('someOperation', FixtureTransport::response([
            'status' => $status,
        ]));

        $response = $this->client($transport)->call('someOperation', []);

        $this->assertSame($status, $response->status ?? null);
    }

    /** @return iterable<string, array{string}> */
    public static function successStatuses(): iterable
    {
        yield 'plain ok' => ['OK'];
        yield 'lowercase ok' => ['ok'];
        yield 'qualified ok' => ['OK_NO_RENEWAL'];
        yield 'eligibility ok' => ['OK_ELIGIBILITY'];
        yield 'availability answer' => ['AVAILABLE'];
        yield 'unavailability answer' => ['UNAVAILABLE'];
        yield 'pending' => ['PENDING'];
    }

    #[Test]
    public function it_throws_on_an_err_status(): void
    {
        $transport = (new FixtureTransport())->on('domainInfo', FixtureTransport::response([
            'status' => 'ERR_DOMAIN_NOT_FOUND',
            'errorMessage' => 'Domain Info Failed - Domain Not Found',
        ]));

        try {
            $this->client($transport)->call('domainInfo', ['domainName' => 'nope.com']);
            $this->fail('Expected an ApiError');
        } catch (ApiError $e) {
            $this->assertSame('ERR_DOMAIN_NOT_FOUND', $e->status);
            $this->assertSame('Domain Info Failed - Domain Not Found', $e->getMessage());
            $this->assertSame('domainInfo', $e->operation);
            $this->assertFalse($e->isAuthFailure());
        }
    }

    #[Test]
    public function it_falls_back_to_the_status_when_no_error_message_is_given(): void
    {
        $transport = (new FixtureTransport())->on('domainInfo', FixtureTransport::response([
            'status' => 'ERR_OCCURED',
        ]));

        $this->expectException(ApiError::class);
        $this->expectExceptionMessage('ERR_OCCURED');

        $this->client($transport)->call('domainInfo', []);
    }

    #[Test]
    public function it_recognises_an_authorisation_failure(): void
    {
        $transport = (new FixtureTransport())->on('balanceQuery', FixtureTransport::response([
            'status' => 'ERR_RESELLER_NOT_AUTHORISED',
            'errorMessage' => 'Reseller not authorised',
        ]));

        try {
            $this->client($transport)->call('balanceQuery', []);
            $this->fail('Expected an ApiError');
        } catch (ApiError $e) {
            $this->assertTrue($e->isAuthFailure());
        }
    }

    #[Test]
    public function it_rejects_a_response_with_no_status_at_all(): void
    {
        $transport = (new FixtureTransport())->on('domainInfo', FixtureTransport::response([
            'domainName' => 'example.com',
        ]));

        $this->expectException(TransportException::class);
        $this->expectExceptionMessage('No status in the response to [domainInfo]');

        $this->client($transport)->call('domainInfo', []);
    }

    #[Test]
    public function it_keeps_credentials_and_auth_codes_out_of_the_log(): void
    {
        $logger = new class () extends AbstractLogger {
            /** @var list<array{string, string, array<string, mixed>}> */
            public array $lines = [];

            /**
             * @param  array<string, mixed>  $context
             */
            public function log($level, \Stringable|string $message, array $context = []): void
            {
                $this->lines[] = [is_string($level) ? $level : 'unknown', (string) $message, $context];
            }
        };

        $transport = (new FixtureTransport())->on('transferDomain', FixtureTransport::response([
            'status' => 'OK',
        ]));

        $this->client($transport, $logger)->call('transferDomain', [
            'domainName' => 'example.com',
            'authInfo' => 'the-epp-code',
        ]);

        $logged = json_encode($logger->lines) ?: '';

        $this->assertStringNotContainsString('secret-key', $logged);
        $this->assertStringNotContainsString('reseller-1', $logged);
        $this->assertStringNotContainsString('the-epp-code', $logged);
        $this->assertStringContainsString('example.com', $logged);
    }
}
