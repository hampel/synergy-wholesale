# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

`hampel/synergy-wholesale` — a typed PHP client for the Synergy Wholesale reseller SOAP API,
covering 138 of the 143 published operations. It has no runtime dependencies beyond `psr/log`
and `ext-soap`, and knows nothing about any framework;
`hampel/synergy-wholesale-laravel` is a separate package that adds Laravel wiring.

Most of `src/` is generated. Read the next section before editing anything under
`src/Generated`.

## Commands

```bash
composer install
composer check                              # lint + analyse + test, what CI runs
composer test                               # phpunit
composer analyse                            # phpstan, level 10, PHP 8.3-8.5
composer format                             # pint
composer generate                           # regenerate src/Generated from resources/wsdl.xml

vendor/bin/phpunit tests/Value/DomainTest.php    # one file
vendor/bin/phpunit --filter it_omits_null        # one test

vendor/bin/rig                              # list the harness exercises
vendor/bin/rig connect                      # run one -- real API call, read-only
```

## Architecture

Three layers, and the boundary between them is what matters:

```
SynergyWholesale  ->  Generated\Api\*Api  ->  Client  ->  Transport  ->  SoapClient
   (groups)            (138 methods)       (envelope)     (seam)
```

- **`SynergyWholesale`** is the entry point and does nothing but hand out group objects —
  `domains()`, `dns()`, `ssl()`, and seven more. `make()` builds a live client; `with()` takes
  any `Transport`.
- **`Generated\Api\*Api`** hold one method per operation. Each is a single line: build the
  parameter array, call `Client::call()`, hydrate the typed response. There is no logic here,
  by design — anything worth testing would otherwise be copied 138 times.
- **`Client`** is where the behaviour lives: it injects credentials, drops null parameters,
  redacts secrets from the log, and applies the envelope rule. **Success is any status not
  prefixed `ERR_`.** That covers `OK`, `OK_NO_RENEWAL`, `AVAILABLE`, `UNAVAILABLE` and anything
  the registry invents next. v1 inverted this — whitelisting success values per response class —
  which is why it threw on statuses that meant success.
- **`Transport`** is the network seam. `SoapTransport` in production (non-WSDL mode, since the
  generator has already consumed the WSDL at build time), `FixtureTransport` in tests. A caching
  or retrying decorator belongs here and nowhere else.
- **`Wire`** holds the hydration helpers. One method per target type (`string()`, `int()`,
  `bool()`, `strings()`, `objects()`, `objectLists()`) rather than one method taking a type name:
  a single method returns a union, and every generated constructor then receives a union where it
  declared one type. Every helper is total — missing fields are null, never an error.
- **`Value\`** is the only hand-written domain logic: `Domain` (which extension a name sits under
  is not derivable from its shape — it needs the second-level-domain list) and `Contact`.

### The generator

`tools/generate-api.php` reads `resources/wsdl.xml` and writes `src/Generated`. The output is
committed, so consumers never run it and a diff shows exactly what changed when Synergy Wholesale
publishes a new WSDL. CI regenerates and fails if the tree is stale.

Four things about the source WSDL that will silently produce wrong code if assumed away:

1. **Types are not named after their operations, and some are shared.** `listDomains` returns
   `bulkDomainInfoResponse`; `hostingEnableTempUrl` takes `hostingGetServiceRequest`. Resolution
   must go `portType -> message -> part type`. Name convention gets nine operations wrong.
2. **`minOccurs` is not trustworthy.** For `transferDomain` the WSDL marks `organisation`, `fax`,
   `idProtect` and `doRenewal` required while the published PDF documents the last two as
   optional and never mentions the first two. `REQUIRED_OVERRIDES` records the discrepancies;
   entries say whether a field **is required**, and the use site inverts them.
3. **Some fields exist in both snake and camel form.** `domainInfoResponse` declares
   `au_valid_eligibility` *and* `auValidEligibility`. Property names are therefore the wire names
   verbatim — any normalisation collapses those pairs and drops a field.
4. **A few types are arrays of arrays.** `listClients` returns `clientListArray` of
   `clientListTypeArray` of the record. `Wire::objectLists()` handles that extra level.

Pint runs at the end of generation, so freshly generated output always passes `pint --test`.

### Adding coverage for a new API operation

Nothing to write by hand: refresh `resources/wsdl.xml` and run `composer generate`. If the new
operation does not land in a sensible group, extend `group_of()`.

## The harness

`harness/` holds `hampel/rig` exercises: `vendor/bin/rig` to list them, `vendor/bin/rig
<name>` to run one. They make real calls against a live reseller account, which is the
point — the suite mocks the transport, so the fixtures encode the same beliefs the code
does, and only a real call can tell you the API still agrees.

**The harness is read-only by construction.** Every call goes through
`harness/lib/ReadOnlyTransport.php`, which holds an allowlist of operations verified
read-only against the v3.16 documentation and refuses everything else. There is no flag
that turns writes on, because there is no flag — an exercise cannot spend money by getting
a method name wrong, only fail.

That is a decorator rather than a per-exercise opt-in because of what this API does. An
opt-in flag protects the exercise that has it and does nothing about the exercise that
calls the wrong method by mistake, and here a mistake registers a domain, transfers one
between registrars, pays a redemption fee or emails a registrant.

### Adding to the allowlist is the dangerous edit

The names do not describe the behaviour, and the traps are not the ones you would guess:

| looks safe | actually |
|---|---|
| `restoreDomain` | takes `redemptionPrice`, *"the price that you are charged"* — a paid redemption |
| `resend*Email` (six of them) | sends real mail to a real registrant |
| `enableTempUrl` | takes `hostingGetServiceRequest`; the type says get, the operation writes |
| `checkDomainEPPCode` | reads, but sits among transfer writers |
| `determineSMSCost` | genuinely a quote — and one method away from `sendSMS` on the same object |

Check the published PDF, not the method name. A read-only operation is described with
"return", "retrieve", "obtain" or "check", and takes no price and no action parameter.

### If a write exercise is ever added

It needs a switch of its own, refused under an agent by `harness_agent_refuses()` in
`harness/lib/agent.php`. Name it after what it unlocks, document it in `.env.example` as
something that must never live in `.env`, and read the note in that file first.

### Credentials

`SW_RESELLER_ID` and `SW_API_KEY`, from `.env` beside the package — copy `.env.example`.
rig does not read that file when `CLAUDECODE` is set, so an agent session fails with a
message saying so. **That is the guard working.** Do not go looking for the key.

Note the API authorises by IP address as well as by key, so a correct key from an unlisted
address fails with `ERR_RESELLER_NOT_AUTHORISED`, which reads like a bad key.

## Conventions

PSR-12 via Pint, PHPStan level 10, PHP 8.3 floor (Tier A: published package, widest
support, CI at the corners). Tests use PHPUnit attributes (`#[Test]`, `#[DataProvider]`)
and snake_case method names.

`harness/` is deliberately outside the PHPStan paths and the test suite: exercises are
driven by hand and assert nothing, so holding them to the runtime's contract buys nothing.
