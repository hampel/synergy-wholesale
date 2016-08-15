<?php  namespace SynergyWholesale\Commands; 

use SynergyWholesale\Types\UsDomain;

class GetUSNexusDataCommand implements Command
{
	/** @var \SynergyWholesale\Types\UsDomain */
	protected $domain;

	public function __construct(UsDomain $domain)
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
