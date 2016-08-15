<?php  namespace SynergyWholesale\Commands;

use SynergyWholesale\Types\AuDomain;

class InitiateAUCORCommand implements Command
{
	/** @var \SynergyWholesale\Types\AuDomain */
	protected $domain;

	public function __construct(AuDomain $domain)
	{
		$this->domain = $domain;
	}

	public function getKey()
	{
		return $this->domain->getName();
	}

	public function getRequestData()
	{
		return array('domainName' => strval($this->domain));
	}
}
