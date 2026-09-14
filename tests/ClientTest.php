<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Tests;

use Closure;
use Hampel\SynergyWholesale\Client;
use Hampel\SynergyWholesale\Exception\ApiError;
use Hampel\SynergyWholesale\Transport\FixtureTransport;
use Hampel\SynergyWholesale\Transport\TransportException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

final class ClientTest extends TestCase
{
    private function client(FixtureTransport $transport, ?LoggerInterface $logger = null): Client
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
        $transport = (new FixtureTransport())->on('transferDomain', FixtureTransport::response([
            'status' => 'OK',
        ]));

        $logged = $this->logged(function (LoggerInterface $logger) use ($transport): void {
            $this->client($transport, $logger)->call('transferDomain', [
                'domainName' => 'example.com',
                'authInfo' => 'the-epp-code',
            ]);
        });

        $this->assertStringNotContainsString('secret-key', $logged);
        $this->assertStringNotContainsString('reseller-1', $logged);
        $this->assertStringNotContainsString('the-epp-code', $logged);
        $this->assertStringContainsString('example.com', $logged);
    }

    /**
     * @param  array<string, mixed>  $request
     * @param  array<string, mixed>  $response
     */
    #[Test]
    #[DataProvider('secrets')]
    public function it_redacts_secrets_at_any_depth_in_either_direction(
        string $operation,
        array $request,
        array $response,
        string $secret,
    ): void {
        $transport = (new FixtureTransport())->on($operation, FixtureTransport::response(
            ['status' => 'OK'] + $response,
        ));

        $logged = $this->logged(function (LoggerInterface $logger) use ($transport, $operation, $request): void {
            $this->client($transport, $logger)->call($operation, $request);
        });

        $this->assertStringNotContainsString($secret, $logged);
        $this->assertStringContainsString('example.com', $logged, 'redaction took the neighbouring fields with it');
    }

    /**
     * @return array<string, array{string, array<string, mixed>, array<string, mixed>, string}>
     */
    public static function secrets(): array
    {
        return [
            'domainPassword on every listDomains entry' => ['listDomains', [], [
                'domainList' => [
                    ['domainName' => 'example.com', 'domainPassword' => 'epp-in-a-list'],
                ],
            ], 'epp-in-a-list'],
            '.au association code in a bulkDomainInfo entry' => ['bulkDomainInfo', [], [
                'domainList' => [
                    ['domainName' => 'example.com', 'auAssociationAuthInfo' => 'au-association-code'],
                ],
            ], 'au-association-code'],
            '.au eligibility association code on domainInfo' => ['domainInfo', ['domainName' => 'example.com'], [
                'auEligibilityAssociationAuthInfo' => 'au-eligibility-code',
            ], 'au-eligibility-code'],
            'authinfo spelt lowercase, nested' => ['rawDomainContacts', ['domainName' => 'example.com'], [
                'contacts' => [['authinfo' => 'lowercase-epp']],
            ], 'lowercase-epp'],
            'authInfo on each bulkRawDomainInfo request entry' => ['bulkRawDomainInfo', [
                'domainList' => [
                    ['domainName' => 'example.com', 'authInfo' => 'epp-in-a-request-list'],
                ],
            ], [], 'epp-in-a-request-list'],
            'newPassword on updateDomainPassword' => ['updateDomainPassword', [
                'domainName' => 'example.com',
                'newPassword' => 'the-new-epp-code',
            ], [], 'the-new-epp-code'],
            'association code on an .au registration' => ['domainRegisterAU', [
                'domainName' => 'example.com',
                'associationAuthInfo' => 'au-registration-code',
            ], [], 'au-registration-code'],
            'private key from SSL_generateCSR' => ['SSL_generateCSR', ['commonName' => 'example.com'], [
                'privKey' => '-----BEGIN PRIVATE KEY-----',
            ], 'BEGIN PRIVATE KEY'],
            'private key on SSL_purchaseSSLCertificate' => ['SSL_purchaseSSLCertificate', [
                'commonName' => 'example.com',
                'privateKey' => '-----BEGIN PRIVATE KEY-----',
            ], [], 'BEGIN PRIVATE KEY'],
        ];
    }

    /**
     * Runs $act against a logger and returns everything it was sent, JSON-encoded, so
     * a test can assert a value appears nowhere in it -- message or context, any depth.
     *
     * A stub rather than an anonymous class implementing LoggerInterface, and the
     * reason is version support: composer.json allows psr/log ^1.0|^2.0|^3.0, whose
     * LoggerInterface::log() signatures are not mutually compatible. v1 declares no
     * parameter or return types; v3 declares string|Stringable and : void. Any
     * concrete signature written here is wrong at one end of that range -- typing
     * $message narrows a parameter against v1 (a fatal), and omitting : void widens
     * the return against v3 (also a fatal). A stub is generated against whichever
     * version is installed, so it is correct at both ends by construction.
     *
     * A stub and not a mock because nothing here asserts on the calls -- it only
     * captures what was logged. PHPUnit emits a notice if you get that backwards.
     *
     * Note this is not the thing FixtureTransport exists to avoid: standing in for a
     * PSR interface is what the interface is for. Faking a concrete SoapClient is not.
     *
     * @param  Closure(LoggerInterface): void  $act
     */
    private function logged(Closure $act): string
    {
        /** @var list<array{string, string, array<mixed>}> $lines */
        $lines = [];

        $logger = $this->createStub(LoggerInterface::class);
        $logger->method('log')->willReturnCallback(
            function (mixed $level, mixed $message, array $context = []) use (&$lines): void {
                $lines[] = [
                    is_string($level) ? $level : 'unknown',
                    is_string($message) || $message instanceof \Stringable ? (string) $message : '(unprintable)',
                    $context,
                ];
            }
        );

        $act($logger);

        return json_encode($lines) ?: '';
    }
}
