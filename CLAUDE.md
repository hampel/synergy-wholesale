# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

`hampel/synergy-wholesale` — a PHP wrapper around the Synergy Wholesale reseller SOAP API
(`https://api.synergywholesale.com/?wsdl`). It has no runtime dependencies beyond `psr/log`, and it
deliberately knows nothing about any framework: `hampel/synergy-wholesale-laravel` is a separate
package that wraps this one with a service provider, facade and response caching.

Only the domain name and SMS portions of the API are implemented.

## Commands

```bash
composer install
vendor/bin/phpunit                                    # whole suite
vendor/bin/phpunit tests/Types/DomainTest.php         # one file
vendor/bin/phpunit --filter testResponse2             # one test
```

There is no linter, no static analysis and no CI workflow in the repo.

## Architecture

Three parallel class families, joined by **naming convention rather than by any registry or map**.
Nothing anywhere lists the API calls; the class names *are* the wiring, so a typo in a class name
is a runtime failure, not a compile-time one.

```
Commands\CheckDomainCommand  --(strip 'Command', lcfirst)-->  SOAP method  checkDomain
                             --(Commands→Responses, Command→Response)-->  Responses\CheckDomainResponse
```

- **`SynergyWholesale`** (`src/SynergyWholesale.php`) is the engine. `execute(Command)` derives the
  SOAP method name from the command's short class name (`deriveSoapCommand`), merges the auth
  credentials into the request array (`prepareOptions`), calls the method on `SoapClient` via
  `call_user_func`, checks a `stdClass` came back, and hands the raw response to the response
  generator. The long list of one-line methods (`checkDomain()`, `domainInfo()`, …) below it is
  typed sugar only — each just calls `execute()`, and exists so IDEs and static analysis can see the
  return type. `resendVerificationEmail()` is the one missing; `execute()` still handles it.
- **`Commands\*`** implement `Command`: `getRequestData()` returns the key-value array sent over the
  wire, and `getKey()` returns a cache key for downstream consumers (the Laravel package) or null
  when the call is uncachable. Commands take **Types** in their constructors, never raw strings, so
  input validation happens before any network call.
- **`Responses\*`** extend `Response`, whose constructor runs a fixed three-step pipeline:
  1. `validateStatus()` — `$response->status` must appear in the subclass's `$successStatus`
     (default `OK`/`ok`; `CheckDomainResponse` overrides it with `AVAILABLE`/`UNAVAILABLE`).
     Anything else throws `ResponseErrorException`.
  2. `validateExpectedFields()` — every name in `$expectedFields` must be set on the raw response.
  3. `validateData()` — an empty hook subclasses override for structural checks (see
     `DomainInfoResponse`, which varies its expectations by TLD).

  So a response object is only ever constructed for a call that succeeded and returned usable data.
  Errors surface as exceptions, never as return values or status flags.
- **`Types\*`** are validating value objects: validate in the constructor and throw on bad input,
  expose `getX()`, `__toString()` and `equals()`, and hold no setters. Enumerated types
  (`AuState`, `Country`, `AuIdType`, `DnsConfiguration`, …) keep their allowed values in a public
  static array and throw their own specific exception subclass.
- **`Exception\*`** all implement the empty marker interface `Exception`, so a caller can catch
  `SynergyWholesale\Exception\Exception` broadly or an individual class narrowly. `SoapException`
  and `ResponseErrorException` carry the command name and raw response for diagnosis.

`BasicResponseGenerator` is the only `ResponseGenerator` implementation; it is injected rather than
hardcoded so consumers can substitute a caching or decorating generator (which is exactly what the
Laravel package does).

### Adding an API call

Five files, and the names must line up exactly or the call fails at runtime:

1. `src/Commands/FooCommand.php` implementing `Command`.
2. `src/Responses/FooResponse.php` extending `Response`.
3. A `foo(Commands\FooCommand $command)` one-liner in `SynergyWholesale`, with the `@return` docblock.
4. `tests/Commands/FooCommandTest.php` — assert the `getRequestData()` array and `getKey()`.
5. `tests/Responses/FooResponseTest.php` — build a `stdClass` by hand as the raw response and assert
   both the accessors and the exceptions thrown on malformed data.

`SoapClient` is mocked with Mockery in `SynergyWholesaleTest`; no test touches the network.

## Conventions

The code targets an old PHP baseline and the style is consistent throughout — match it rather than
modernising in passing: tabs, Allman braces, `array()` literals, `namespace` on the same line as
`<?php`, docblock types instead of scalar type hints or return types, and `OR`/`AND` as the boolean
operators.

Credentials are redacted before logging (`resellerID`, `apiKey` in `logCommand`, `domainPassword`
in `logResponse`) — preserve that when touching the logging path. The logger is optional and every
call goes through `log()`, which no-ops when none was injected.
