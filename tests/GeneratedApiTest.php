<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Tests;

use Closure;
use Hampel\SynergyWholesale\Generated\Api\DomainsApi;
use Hampel\SynergyWholesale\SynergyWholesale;
use Hampel\SynergyWholesale\Transport\FixtureTransport;
use Hampel\SynergyWholesale\Value\Contact;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;

/**
 * Exercises the generated surface end to end: a call goes out with the right
 * field names and a real response shape comes back hydrated.
 *
 * The response fixtures here are the worked examples from the published API
 * documentation, so a change in the generator that broke hydration would show
 * up against what the registry actually sends.
 */
final class GeneratedApiTest extends TestCase
{
    private function api(FixtureTransport $transport): SynergyWholesale
    {
        return SynergyWholesale::with($transport, 'reseller-1', 'secret-key');
    }

    #[Test]
    public function it_hydrates_a_check_domain_response(): void
    {
        $transport = (new FixtureTransport())->on('checkDomain', FixtureTransport::response([
            'status' => 'AVAILABLE',
            'available' => 1,
            'costPrice' => '12.95',
            'basePrice' => '14.95',
            'premium' => false,
        ]));

        $response = $this->api($transport)->domains()->checkDomain(domainName: 'example.com');

        $this->assertSame(1, $response->available);
        $this->assertSame('12.95', $response->costPrice);
        $this->assertSame('14.95', $response->basePrice);
        $this->assertFalse($response->premium);

        $this->assertSame([
            'resellerID' => 'reseller-1',
            'apiKey' => 'secret-key',
            'domainName' => 'example.com',
        ], $transport->lastRequest());
    }

    /**
     * The premium fields above are the point of this one: v1 exposed only
     * isAvailable(), so premium pricing -- added to the API in 2020 -- was
     * unreachable through the package at all.
     */
    #[Test]
    public function it_hydrates_a_domain_info_response_including_its_nested_list(): void
    {
        $transport = (new FixtureTransport())->on('domainInfo', FixtureTransport::response([
            'status' => 'OK',
            'domainName' => 'example.com.au',
            'domain_status' => 'Active',
            'domain_expiry' => '2027-11-14T00:58:33.0Z',
            'nameServers' => ['ns1.example.com', 'ns2.example.com'],
            'dnsConfig' => 1,
            'dnsConfigName' => 'Custom Nameservers',
            'autoRenew' => 'Enabled',
            'icannStatus' => 'Verified',
        ]));

        $response = $this->api($transport)->domains()->domainInfo(domainName: 'example.com.au');

        $this->assertSame('example.com.au', $response->domainName);
        $this->assertSame('Active', $response->domain_status);
        $this->assertSame(['ns1.example.com', 'ns2.example.com'], $response->nameServers);
        $this->assertSame(1, $response->dnsConfig);
        $this->assertNull($response->domainRoid);
    }

    #[Test]
    public function it_flattens_contacts_into_role_prefixed_fields(): void
    {
        $transport = (new FixtureTransport())->on('domainRegister', FixtureTransport::response([
            'status' => 'OK',
        ]));

        $contact = new Contact(
            firstname: 'John',
            lastname: 'Smith',
            address: ['1 Infinite Loop'],
            suburb: 'Cupertino',
            state: 'CA',
            country: 'US',
            postcode: '95014',
            phone: '+1.4085551234',
            email: 'john@example.com',
        );

        $this->api($transport)->domains()->domainRegister(
            domainName: 'example.com',
            years: '2',
            registrant: $contact,
            nameServers: ['ns1.example.com'],
        );

        $request = $transport->lastRequest() ?? [];

        $this->assertSame('John', $request['registrant_firstname']);
        $this->assertSame(['1 Infinite Loop'], $request['registrant_address']);
        $this->assertSame('US', $request['registrant_country']);
        $this->assertSame(['ns1.example.com'], $request['nameServers']);

        // Optional contact fields the caller did not set, and the whole of the
        // admin/technical/billing sets, must be absent rather than null: the
        // API falls back to the registrant when a set is missing entirely.
        $this->assertArrayNotHasKey('registrant_organisation', $request);
        $this->assertArrayNotHasKey('registrant_fax', $request);
        $this->assertArrayNotHasKey('admin_firstname', $request);
        $this->assertArrayNotHasKey('technical_firstname', $request);
        $this->assertArrayNotHasKey('billing_firstname', $request);
    }

    /**
     * The WSDL shares types between operations, so listDomains returns
     * bulkDomainInfoResponse rather than a type named after itself. Generating
     * by name convention would have produced a class that never matched the
     * wire; this pins the resolution.
     */
    #[Test]
    public function list_domains_returns_the_shared_bulk_domain_info_type(): void
    {
        $method = new ReflectionMethod(DomainsApi::class, 'listDomains');

        $this->assertSame(
            'Hampel\SynergyWholesale\Generated\Response\BulkDomainInfoResponse',
            (string) $method->getReturnType(),
        );
    }

    /**
     * status and errorMessage are the envelope on an operation's response, and
     * Client consumes them. On a nested type they are data -- here a per-entry
     * result, so a name that is not in the account is distinguishable from a
     * record whose fields are empty.
     */
    #[Test]
    public function it_keeps_status_on_nested_entries_while_consuming_the_envelope(): void
    {
        $transport = (new FixtureTransport())->on('bulkDomainInfo', FixtureTransport::response([
            'status' => 'OK',
            'domainList' => [
                ['status' => 'OK', 'domainName' => 'example.com', 'domain_status' => 'ok'],
                ['status' => 'ERR_DOMAIN_NOT_FOUND', 'errorMessage' => 'Domain not found', 'domainName' => 'example.net'],
            ],
        ]));

        $response = $this->api($transport)->domains()->bulkDomainInfo(domainList: ['example.com', 'example.net']);

        $this->assertFalse((new ReflectionClass($response))->hasProperty('status'));
        $this->assertNotNull($response->domainList);
        [$found, $missing] = $response->domainList;
        $this->assertSame('OK', $found->status);
        $this->assertNull($found->errorMessage);
        $this->assertSame('ERR_DOMAIN_NOT_FOUND', $missing->status);
        $this->assertSame('Domain not found', $missing->errorMessage);
    }

    #[Test]
    public function it_keeps_a_certificates_own_status(): void
    {
        $transport = (new FixtureTransport())->on('SSL_listAllCerts', FixtureTransport::response([
            'status' => 'OK',
            'certs' => [
                ['certID' => '1', 'commonName' => 'example.com', 'status' => 'Issued'],
            ],
        ]));

        $certs = $this->api($transport)->ssl()->listAllCerts()->certs;

        $this->assertNotNull($certs);
        $this->assertSame('Issued', $certs[0]->status);
    }

    #[Test]
    public function every_group_exposes_only_generated_api_methods(): void
    {
        $sw = $this->api(new FixtureTransport());
        $total = 0;
        $forwards = 0;

        foreach ((new ReflectionClass(SynergyWholesale::class))->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if (in_array($method->getName(), ['__construct', 'make', 'with'], true)) {
                continue;
            }

            /** @var object $group */
            $group = $sw->{$method->getName()}();
            foreach ((new ReflectionClass($group))->getMethods(ReflectionMethod::IS_PUBLIC) as $operation) {
                if ($operation->isConstructor()) {
                    continue;
                }

                str_contains((string) $operation->getDocComment(), '@deprecated') ? $forwards++ : $total++;
            }
        }

        // 143 operations in the WSDL, less the five deprecated in API v3.4. Each is
        // counted once: a moved operation's old location is a forwarding method.
        $this->assertSame(138, $total);
        $this->assertSame(3, $forwards);
    }

    /**
     * listHosting and bulkHostingInfo were generated under registryHosts(), and
     * getSSLPricing under domains(), until the grouping rule was corrected. The old
     * locations stay as deprecated methods that forward, so a caller still using them
     * sends exactly the request the new location does.
     *
     * @param  Closure(SynergyWholesale): object  $old
     * @param  Closure(SynergyWholesale): object  $new
     */
    #[Test]
    #[DataProvider('movedOperations')]
    public function a_moved_operation_still_answers_where_it_used_to(string $operation, Closure $old, Closure $new): void
    {
        $response = FixtureTransport::response(['status' => 'OK']);

        $viaOld = (new FixtureTransport())->on($operation, $response);
        $viaNew = (new FixtureTransport())->on($operation, $response);

        $this->assertEquals($new($this->api($viaNew)), $old($this->api($viaOld)));
        $this->assertSame($viaNew->lastRequest(), $viaOld->lastRequest());
        $this->assertSame([$operation], array_column($viaOld->calls, 'operation'));
    }

    /**
     * @return array<string, array{string, Closure(SynergyWholesale): object, Closure(SynergyWholesale): object}>
     */
    public static function movedOperations(): array
    {
        return [
            'listHosting' => [
                'listHosting',
                static fn (SynergyWholesale $sw): object => $sw->registryHosts()->listHosting(status: 'active', page: 2),
                static fn (SynergyWholesale $sw): object => $sw->hosting()->listHosting(status: 'active', page: 2),
            ],
            'bulkHostingInfo' => [
                'bulkHostingInfo',
                static fn (SynergyWholesale $sw): object => $sw->registryHosts()->bulkHostingInfo(hoidList: ['H1', 'H2']),
                static fn (SynergyWholesale $sw): object => $sw->hosting()->bulkHostingInfo(hoidList: ['H1', 'H2']),
            ],
            'getSSLPricing' => [
                'getSSLPricing',
                static fn (SynergyWholesale $sw): object => $sw->domains()->getSSLPricing(),
                static fn (SynergyWholesale $sw): object => $sw->ssl()->getSSLPricing(),
            ],
        ];
    }

    /**
     * The five register/transfer variants Synergy Wholesale deprecated in
     * February 2020 must not be generated: they still answer, which is exactly
     * what makes shipping them a trap.
     */
    #[Test]
    public function deprecated_operations_are_not_generated(): void
    {
        $methods = get_class_methods(DomainsApi::class);

        foreach (['domainRegisterAU', 'domainRegisterUK', 'domainRegisterUS', 'domainTransferUK', 'resubmitFailedTransfer'] as $gone) {
            $this->assertNotContains($gone, $methods, "{$gone} is deprecated and should not be generated");
        }
    }
}
