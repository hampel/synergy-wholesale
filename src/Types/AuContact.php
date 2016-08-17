<?php  namespace SynergyWholesale\Types;

use SynergyWholesale\Exception\InvalidArgumentException;

class AuContact extends Contact
{
	function __construct(
		$firstname, $lastname,
		$organisation,
		$address1, $address2, $address3,
		$suburb,
		AuState $state,
		AuPostCode $postcode,
		Phone $phone,
		Email $email,
		Phone $fax = null
	)
	{
		if (empty($firstname)) throw new InvalidArgumentException("firstname parameter is required");
		if (empty($lastname)) throw new InvalidArgumentException("lastname parameter is required");
		if (empty($address1)) throw new InvalidArgumentException("address1 parameter is required");
		if (empty($suburb)) throw new InvalidArgumentException("suburb parameter is required");

		$this->firstname = $firstname;
		$this->lastname = $lastname;
		$this->organisation = $organisation;
		$this->address1 = $address1;
		$this->address2 = $address2;
		$this->address3 = $address3;
		$this->suburb = $suburb;
		$this->state = $state;
		$this->country = new Country('AU');
		$this->postcode = $postcode;
		$this->phone = $phone;
		$this->email = $email;
		$this->fax = $fax;
	}

	public static function newFromArray(array $contact)
	{
		return new self(
			$contact['firstname'],
			$contact['lastname'],
			$contact['organisation'],
			$contact['address1'],
			$contact['address2'],
			$contact['address3'],
			$contact['suburb'],
			new AuState($contact['state']),
			new AuPostCode($contact['postcode']),
			new Phone($contact['phone']),
			new Email($contact['email']),
			is_null($contact['fax']) ? null : new Phone($contact['fax'])
		);
	}

	public function getStateName()
	{
		return $this->state->getState();
	}

	public function getPostcodeString()
	{
		return $this->postcode->getPostcode();
	}

	public function equals(Contact $other)
	{
		if (is_null($this->fax) xor is_null($other->fax)) return false;

		return $this->firstname === $other->firstname &&
			$this->lastname === $other->lastname &&
			$this->organisation === $other->organisation &&
			$this->address1 === $other->address1 &&
			$this->address2 === $other->address2 &&
			$this->address3 === $other->address3 &&
			$this->suburb === $other->suburb &&
			$this->state->equals($other->state) &&
			$this->country->equals($other->country) &&
			$this->postcode->equals($other->postcode) &&
			$this->phone->equals($other->phone) &&
			$this->email->equals($other->email) &&
			$this->fax->equals($other->fax);
	}

	public function toArray()
	{
		return [
			'firstname' => $this->firstname,
			'lastname' => $this->lastname,
			'organisation' => $this->organisation,
			'address1' => $this->address1,
			'address2' => $this->address2,
			'address3' => $this->address3,
			'suburb' => $this->suburb,
			'state' => $this->state->getState(),
			'country' => $this->country->getCountryCode(),
			'postcode' => $this->postcode->getPostcode(),
			'phone' => $this->phone->getPhone(),
			'email' => $this->email->getEmail(),
			'fax' => $this->fax ? $this->fax->getPhone() : null,
		];
	}
}
