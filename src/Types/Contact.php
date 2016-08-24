<?php  namespace SynergyWholesale\Types; 

use SynergyWholesale\Exception\InvalidArgumentException;

class Contact
{
	protected $firstname;
	protected $lastname;
	protected $organisation;
	protected $address1;
	protected $address2;
	protected $address3;
	protected $suburb;
	protected $state;
	protected $country;
	protected $postcode;
	protected $phone;
	protected $email;
	protected $fax;

	function __construct(
		$firstname, $lastname,
		$organisation,
		$address1, $address2, $address3,
		$suburb, $state,
		Country $country,
		$postcode,
		Phone $phone,
		Email $email,
		Phone $fax = null
	)
	{
		if (empty($firstname)) throw new InvalidArgumentException("firstname parameter is required");
		if (empty($lastname)) throw new InvalidArgumentException("lastname parameter is required");
		if (empty($address1)) throw new InvalidArgumentException("address1 parameter is required");
		if (empty($suburb)) throw new InvalidArgumentException("suburb parameter is required");
		if (empty($state)) throw new InvalidArgumentException("state parameter is required");
		if (empty($postcode)) throw new InvalidArgumentException("postcode parameter is required");

		$this->firstname = $firstname;
		$this->lastname = $lastname;
		$this->organisation = $organisation;
		$this->address1 = $address1;
		$this->address2 = $address2;
		$this->address3 = $address3;
		$this->suburb = $suburb;
		$this->state = $state;
		$this->country = $country;
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
			$contact['state'],
			new Country($contact['country']),
			$contact['postcode'],
			new Phone($contact['phone']),
			new Email($contact['email']),
			is_null($contact['fax']) ? null : new Phone($contact['fax'])
		);
	}

	public function getFirstname()
	{
		return $this->firstname;
	}

	public function getLastname()
	{
		return $this->lastname;
	}

	public function getOrganisation()
	{
		return $this->organisation;
	}

	public function getAddress1()
	{
		return $this->address1;
	}

	public function getAddress2()
	{
		return $this->address2;
	}

	public function getAddress3()
	{
		return $this->address3;
	}

	public function getSuburb()
	{
		return $this->suburb;
	}

	public function getState()
	{
		return $this->state;
	}

	public function getCountry()
	{
		return $this->country;
	}

	public function getCountryCode()
	{
		return $this->country->getCountryCode();
	}

	public function getPostcode()
	{
		return $this->postcode;
	}

	public function getPhone()
	{
		return $this->phone;
	}

	public function getPhoneNumber()
	{
		return $this->phone->getPhone();
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function getEmailAddress()
	{
		return $this->email->getEmail();
	}

	public function getFax()
	{
		return $this->fax;
	}

	public function getFaxNumber()
	{
		if (isset($this->fax)){
			return $this->fax->getPhone();
		}
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
			$this->state === $other->state &&
			$this->country->equals($other->country) &&
			$this->postcode === $other->postcode &&
			$this->phone->equals($other->phone) &&
			$this->email->equals($other->email) &&
			((is_null($this->fax) && is_null($other->fax)) || $this->fax->equals($other->fax));
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
			'state' => $this->state,
			'country' => $this->country->getCountryCode(),
			'postcode' => $this->postcode,
			'phone' => $this->phone->getPhone(),
			'email' => $this->email->getEmail(),
			'fax' => $this->fax ? $this->fax->getPhone() : null,
		];
	}
}
