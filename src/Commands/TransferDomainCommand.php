<?php  namespace SynergyWholesale\Commands;

use SynergyWholesale\Types\Boolean;
use SynergyWholesale\Types\Domain;
use SynergyWholesale\Types\Contact;
use SynergyWholesale\Exception\InvalidArgumentException;

class TransferDomainCommand implements Command
{
	/** @var \SynergyWholesale\Types\Domain */
	protected $domain;

	/** @var string */
	protected $authInfo;

	/** @var \SynergyWholesale\Types\Contact */
	protected $contact;

	/** @var \SynergyWholesale\Types\Boolean */
	protected $idProtect;

	/** @var \SynergyWholesale\Types\Boolean */
	protected $doRenewal;

	function __construct(
		Domain $domain,
		$authInfo,
		Contact $contact,
		Boolean $idProtect = null,
		Boolean $doRenewal = null
	)
	{
		if (empty($authInfo) OR !is_string($authInfo))
		{
			throw new InvalidArgumentException("authInfo parameter is required");
		}

		$this->domain = $domain;
		$this->authInfo = $authInfo;
		$this->contact = $contact;
		$this->idProtect = $idProtect;
		$this->doRenewal = $doRenewal;
	}

	public function getKey()
	{
		return $this->domain->getName();
	}

	public function getRequestData()
	{
		return array(
			'domainName' => $this->domain->getName(),
			'authInfo' => $this->authInfo,

			'firstname' => $this->contact->getFirstname(),
			'lastname' => $this->contact->getLastname(),
			'organisation' => $this->contact->getOrganisation(),
			'address' => array(
					$this->contact->getAddress1(),
					$this->contact->getAddress2(),
					$this->contact->getAddress3()
				),
			'suburb' => $this->contact->getSuburb(),
			'state' => $this->contact->getState(),
			'country' => $this->contact->getCountryCode(),
			'postcode' => $this->contact->getPostcode(),
			'phone' => $this->contact->getPhoneNumber(),
			'fax' => $this->contact->getFaxNumber(),
			'email' => $this->contact->getEmailAddress(),

			'idProtect' => $this->idProtect->isTrue() ? 'Y' : '',
			'doRenewal' => $this->doRenewal->isFalse() ? '0' : ''
		);
	}
}
