<?php

/**
 * Not an exercise - see lib/agent.php for why files live down here.
 *
 * This is layer 2 for this harness, and it is a decorator rather than a per-exercise
 * default because of what the package wraps. Synergy Wholesale is a domain registrar:
 * the operations next door to the ones worth exercising register domains, transfer them
 * between registrars, pay redemption fees and send email to real registrants. An opt-in
 * flag guards the exercise that has it. It does nothing about the exercise that calls
 * the wrong method by mistake, and on this API a mistake is chargeable.
 *
 * So the harness is read-only by CONSTRUCTION. Every call is routed through here, and an
 * operation not on the list below does not reach the network - no flag turns it on,
 * because there is no flag. An exercise cannot spend money by getting a method name
 * wrong; it can only fail.
 *
 * Note that the guard sits at the transport, which is the one place everything passes
 * through. Putting it in the exercises would mean trusting each of them, which is the
 * thing being avoided.
 *
 * ADDING TO THE LIST IS THE DANGEROUS EDIT IN THIS PACKAGE. The names are not
 * self-describing and the traps are not the ones you would guess:
 *
 *   restoreDomain        takes redemptionPrice - "the price that you are charged". A paid
 *                        redemption, behind a name that reads like a rollback.
 *   resend*Email         six operations that send real mail to a real registrant.
 *   enableTempUrl        takes hostingGetServiceRequest. The type says get; it writes.
 *   checkDomainEPPCode   reads, but sits among writers, and the group is transfers.
 *   determineSMSCost     genuinely a quote, no side effect - and one method away from
 *                        sendSMS on the same object, which costs money and reaches a
 *                        real phone. Left off on adjacency, not on behaviour.
 *
 * Every name below was checked against the v3.16 PDF - the wording is "return",
 * "retrieve", "obtain" or "check", and none takes a price or an action parameter.
 * Check the PDF, not the method name, before adding one.
 */

use Hampel\SynergyWholesale\Transport\Transport;
use Hampel\SynergyWholesale\Transport\TransportException;

final class ReadOnlyTransport implements Transport
{
    /**
     * Operations this harness may call. Verified read-only against the Synergy Wholesale
     * API documentation v3.16.
     */
    public const ALLOWED = [
        // Account.
        'balanceQuery',

        // Catalogue. Identical for every reseller - nothing account-specific in the
        // output, which is what makes catalogue.php safe to paste into a bug report.
        'listAvailableDomainExtensions',
        'getDomainPricing',
        'getSSLPricing',
        'getDomainExtensionOptions',

        // Availability. Free, and unobservable to the domain's owner.
        'checkDomain',
        'bulkCheckDomain',

        // The account's own domains.
        'listDomains',
        'domainInfo',
        'listContacts',
    ];

    public function __construct(private readonly Transport $inner)
    {
    }

    public function call(string $operation, array $request): object
    {
        if (! in_array($operation, self::ALLOWED, true)) {
            throw new TransportException(
                sprintf(
                    'Refusing [%s]: this harness is read-only and that operation is not on the '
                    . 'allowlist in harness/lib/ReadOnlyTransport.php. Read the note there before '
                    . 'adding it - several write operations on this API have read-like names.',
                    $operation,
                ),
                $operation,
            );
        }

        return $this->inner->call($operation, $request);
    }
}
