<?php  namespace SynergyWholesale\Commands;

use SynergyWholesale\Types\Domain;

class DisableIDProtectionCommand implements Command
{
	/** @var \SynergyWholesale\Types\Domain  */
	protected $domain;

	public function __construct(Domain $domain)
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
