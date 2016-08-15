<?php  namespace SynergyWholesale\Commands;

use SynergyWholesale\Types\Domain;
use SynergyWholesale\Exception\InvalidArgumentException;
use SynergyWholesale\Types\RegistrationYears;

class RenewDomainCommand implements Command
{
	/** @var \SynergyWholesale\Types\Domain */
	protected $domain;

	/** @var \SynergyWholesale\Types\RegistrationYears */
	protected $years;

	function __construct(
		Domain $domain,
		RegistrationYears $years
	)
	{
		$this->domain = $domain;
		$this->years = $years;
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
		);
	}
}
