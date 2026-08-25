<?php

declare(strict_types=1);

namespace Hampel\SynergyWholesale\Value;

use Hampel\SynergyWholesale\Exception\InvalidArgument;

/**
 * One contact set: registrant, technical, admin or billing.
 *
 * The API expresses these as eleven flat fields per role, prefixed with the
 * role name -- registrant_firstname, technical_firstname and so on -- which is
 * why domainRegister nominally takes 57 parameters. Four of these objects
 * account for 44 of them.
 *
 * Only organisation and fax are optional; the published documentation marks
 * the rest mandatory. Where a register or transfer call omits a role
 * altogether, the API falls back to the registrant.
 */
final class Contact
{
    /**
     * @param  list<string>  $address one or more address lines
     */
    public function __construct(
        public readonly string $firstname,
        public readonly string $lastname,
        public readonly array $address,
        public readonly string $suburb,
        public readonly string $state,
        public readonly string $country,
        public readonly string $postcode,
        public readonly string $phone,
        public readonly string $email,
        public readonly ?string $organisation = null,
        public readonly ?string $fax = null,
    ) {
        if ($address === []) {
            throw new InvalidArgument('A contact needs at least one address line');
        }

        if (strlen($country) !== 2) {
            throw new InvalidArgument("Country must be a two-letter code, got [{$country}]");
        }
    }

    /**
     * Flattens this contact into the role-prefixed fields the API expects.
     *
     * An empty role produces unprefixed fields, which is what transferDomain
     * takes: one contact set at the top level rather than four prefixed ones.
     *
     * Accepts null so the generated call sites can spread it unconditionally:
     * an omitted contact contributes nothing rather than a set of null fields.
     *
     * @return array<string, string|list<string>>
     */
    public static function wire(string $role, ?self $contact): array
    {
        if ($contact === null) {
            return [];
        }

        $prefix = $role === '' ? '' : "{$role}_";

        $fields = [
            'firstname' => $contact->firstname,
            'lastname' => $contact->lastname,
            'address' => $contact->address,
            'suburb' => $contact->suburb,
            'state' => $contact->state,
            'country' => $contact->country,
            'postcode' => $contact->postcode,
            'phone' => $contact->phone,
            'email' => $contact->email,
            'organisation' => $contact->organisation,
            'fax' => $contact->fax,
        ];

        $out = [];
        foreach ($fields as $name => $value) {
            if ($value !== null) {
                $out["{$prefix}{$name}"] = $value;
            }
        }

        return $out;
    }
}
