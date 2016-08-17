<?php  namespace SynergyWholesale\Commands;

use SynergyWholesale\Types\Contact;
use SynergyWholesale\Types\DomainList;
use SynergyWholesale\Types\RegistrationYears;
use SynergyWholesale\Types\UkDomain;
use SynergyWholesale\Exception\InvalidArgumentException;

class DomainRegisterUKCommand implements Command
{
	/** @var \SynergyWholesale\Types\UkDomain */
	protected $domain;

	/** @var \SynergyWholesale\Types\RegistrationYears */
	protected $years;

	/** @var \SynergyWholesale\Types\DomainList */
	protected $nameServers;

	/** @var \SynergyWholesale\Types\Contact */
	protected $contact;

	function __construct(
		UkDomain $domain,
		RegistrationYears $years,
		DomainList $nameServers = null,
		Contact $contact
	)
	{
		$this->domain = $domain;
		$this->years = $years;
		$this->nameServers = $nameServers;
		$this->contact = $contact;
	}

	public function getKey()
	{
		return $this->domain->getName();
	}

	public function getRequestData()
	{
		return array(
			'domainName' => $this->domain->getName(),
			'years' => $this->years->getYears(),
			'nameServers' => isset($this->nameServers) ? $this->nameServers->getDomainNames() : null,

			'contact_firstname' => $this->contact->getFirstname(),
			'contact_lastname' => $this->contact->getLastname(),
			'contact_organisation' => $this->contact->getOrganisation(),
			'contact_address' => array(
					$this->contact->getAddress1(),
					$this->contact->getAddress2(),
					$this->contact->getAddress3()
				),
			'contact_suburb' => $this->contact->getSuburb(),
			'contact_state' => $this->contact->getState(),
			'contact_country' => $this->contact->getCountryCode(),
			'contact_postcode' => $this->contact->getPostcode(),
			'contact_phone' => $this->contact->getPhoneNumber(),
			'contact_fax' => $this->contact->getFaxNumber(),
			'contact_email' => $this->contact->getEmailAddress(),
		);
	}
}
