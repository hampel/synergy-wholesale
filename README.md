# Synergy Wholesale API Client

[![Tests](https://github.com/hampel/synergy-wholesale/actions/workflows/tests.yml/badge.svg)](https://github.com/hampel/synergy-wholesale/actions/workflows/tests.yml)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/hampel/synergy-wholesale.svg?style=flat-square)](https://packagist.org/packages/hampel/synergy-wholesale)
[![Total Downloads](https://img.shields.io/packagist/dt/hampel/synergy-wholesale.svg?style=flat-square)](https://packagist.org/packages/hampel/synergy-wholesale)
[![Open Issues](https://img.shields.io/github/issues-raw/hampel/synergy-wholesale.svg?style=flat-square)](https://github.com/hampel/synergy-wholesale/issues)
[![License](https://img.shields.io/packagist/l/hampel/synergy-wholesale.svg?style=flat-square)](https://packagist.org/packages/hampel/synergy-wholesale)

A typed PHP client for the [Synergy Wholesale](https://synergywholesale.com/) reseller API,
generated from their published WSDL.

By [Simon Hampel](mailto:simon@hampelgroup.com)

All 138 supported operations are covered — domains, DNS, DNSSEC, email and URL forwarding,
SSL, hosting, subscriptions and SMS — with typed parameters and typed response objects
throughout.

## Installation

```bash
composer require hampel/synergy-wholesale
```

Requires PHP 8.3 or later and the `soap` extension.

For Laravel, install
[hampel/synergy-wholesale-laravel](https://packagist.org/packages/hampel/synergy-wholesale-laravel),
which adds a service provider, a facade and configuration on top of this package.

## Getting started

Turn on API access in your Synergy Wholesale control panel to get your Reseller ID, and add
your server's IP address to the whitelist to enable an API key. Note that authorisation is by
IP address **as well as** by key: correct credentials from an unlisted address fail with
`ERR_RESELLER_NOT_AUTHORISED`.

```php
use Hampel\SynergyWholesale\SynergyWholesale;

$sw = SynergyWholesale::make('reseller-id', 'api-key');

// Optionally pass any PSR-3 logger to record calls and responses.
// Credentials, EPP and .au association codes, passwords and private keys are redacted, at
// any depth. Everything else is logged in full at debug, including registrant and contact
// names, email addresses, phone numbers and postal addresses.
$sw = SynergyWholesale::make('reseller-id', 'api-key', $logger);
```

## Making calls

Operations are grouped, and within a group the method is the API operation name with the
group's own prefix removed. The published PDF documentation therefore reads directly as the
reference — "Command: `checkDomain`" is `$sw->domains()->checkDomain()`, and
"Command: `SSL_getCertStatus`" is `$sw->ssl()->getCertStatus()`.

```php
$check = $sw->domains()->checkDomain(domainName: 'example.com');

$check->available;   // 1 or 0
$check->costPrice;   // '12.95'
$check->premium;     // bool
```

Response properties carry the API's own field names, so `domain_expiry` in the documentation
is `->domain_expiry` here, with no translation step to get wrong. Every response field is
nullable: the API omits fields routinely, and `domainInfo` alone varies its shape by TLD.

```php
$info = $sw->domains()->domainInfo(domainName: 'example.com.au');

$info->domain_status;    // 'Active'
$info->domain_expiry;    // '2027-11-14T00:58:33.0Z'
$info->nameServers;      // ['ns1.example.com', 'ns2.example.com']
$info->auRegistrantName; // null for a non-.au domain
```

The available groups are `domains()`, `dns()`, `dnssec()`, `forwarding()`, `categories()`,
`registryHosts()`, `ssl()`, `hosting()`, `subscriptions()` and `sms()`.

### Contacts

Registration and transfer take contact sets. The API expresses these as eleven flat fields per
role, which is why `domainRegister` nominally takes 57 parameters; the `Contact` value object
collapses four of those sets into four arguments.

```php
use Hampel\SynergyWholesale\Value\Contact;

$registrant = new Contact(
    firstname: 'John',
    lastname:  'Smith',
    address:   ['1 Infinite Loop'],
    suburb:    'Cupertino',
    state:     'CA',
    country:   'US',
    postcode:  '95014',
    phone:     '+1.4085551234',
    email:     'john@example.com',
);

$sw->domains()->domainRegister(
    domainName:  'example.com',
    years:       '2',
    registrant:  $registrant,
    nameServers: ['ns1.example.com', 'ns2.example.com'],
    idProtect:   'true',
);
```

Omit the `technical`, `admin` and `billing` arguments and the API falls back to the registrant.

## Errors

Every operation returns the same envelope, and any status prefixed `ERR_` is thrown as an
`ApiError`. Anything else is a successful call — including `AVAILABLE`, `UNAVAILABLE` and the
`OK_NO_RENEWAL` and `OK_ELIGIBILITY` variants.

```php
use Hampel\SynergyWholesale\Exception\ApiError;
use Hampel\SynergyWholesale\Exception\SynergyWholesaleException;

try {
    $info = $sw->domains()->domainInfo(domainName: 'example.com');
} catch (ApiError $e) {
    $e->status;          // 'ERR_DOMAIN_NOT_FOUND'
    $e->getMessage();    // the API's errorMessage
    $e->operation;       // 'domainInfo'
    $e->response;        // the raw response object
    $e->isAuthFailure(); // credentials or IP whitelist
}
```

`ApiError` (the API said no) and `TransportException` (the call could not be completed) both
implement `SynergyWholesaleException`, so a caller can catch the whole package with one clause
or each failure mode individually.

## Testing against the client

`SynergyWholesale::with()` accepts any `Transport`, so tests need neither a network nor a mock
of `SoapClient`:

```php
use Hampel\SynergyWholesale\Transport\FixtureTransport;

$transport = (new FixtureTransport())->on('checkDomain', FixtureTransport::response([
    'status'    => 'AVAILABLE',
    'available' => 1,
]));

$sw = SynergyWholesale::with($transport, 'reseller-id', 'api-key');

$this->assertSame(1, $sw->domains()->checkDomain(domainName: 'example.com')->available);
$this->assertSame('example.com', $transport->lastRequest()['domainName']);
```

The same seam takes a decorator, which is where caching, retries or rate limiting belong.

## Regenerating

`src/Generated` is produced from `resources/wsdl.xml` and committed, so installing this package
never runs the generator. When Synergy Wholesale publishes a new WSDL:

```bash
curl -o resources/wsdl.xml 'https://api.synergywholesale.com/?wsdl'
composer generate
```

The diff then shows exactly what changed in the API. CI regenerates on every push and fails if
the committed output has drifted.

## Deprecated operations

The five registry-specific calls Synergy Wholesale deprecated in API v3.4 (February 2020) are
deliberately not generated: `domainRegisterAU`, `domainRegisterUK`, `domainRegisterUS`,
`domainTransferUK` and `resubmitFailedTransfer`. They still answer, which is what makes
shipping them a trap. Use `domainRegister` and `transferDomain` with `getDomainEligibilityFields`
and `generateAuEligibility` instead.

## Upgrading from 1.x

Version 2 is a complete rewrite and shares no API with 1.x.

| 1.x | 2.x |
|---|---|
| `SynergyWholesale\` namespace | `Hampel\SynergyWholesale\` |
| `new CheckDomainCommand(new Domain(…))` then `execute()` | `$sw->domains()->checkDomain(domainName: …)` |
| `$response->isAvailable()` | `$response->available`, plus `premium`, `costPrice`, `basePrice` |
| Success whitelisted per response class | Any status not prefixed `ERR_` |
| 36 of 143 operations | 138 of 143 |
| PHP 5.4 | PHP 8.3 |

Response caching has been removed. It was per-operation, invalidated by hand-wired pairs, and
in one case fabricated a response object to satisfy a constructor. Cache the wire response
behind a `Transport` decorator instead.

## Licence

MIT — see [LICENSE.md](LICENSE.md).
