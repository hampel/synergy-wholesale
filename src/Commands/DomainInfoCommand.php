<?php namespace SynergyWholesale\Commands;

use SynergyWholesale\Types\Domain;

class DomainInfoCommand implements Command
{
	/** @var \SynergyWholesale\Types\Domain */
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
		return array('domainName' => $this->domain->getName());
	}
}
