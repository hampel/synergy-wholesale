<?php  namespace SynergyWholesale\Commands;

use SynergyWholesale\Types\Domain;
use SynergyWholesale\Types\DomainList;
use SynergyWholesale\Types\DnsConfiguration;

class UpdateNameServersCommand implements Command
{
	/** @var \SynergyWholesale\Types\Domain */
	protected $domain;

	/** @var \SynergyWholesale\Types\DomainList */
	protected $nameServers;

	/** @var \SynergyWholesale\Types\DnsConfiguration */
	protected $dnsConfigType;

	function __construct(
		Domain $domain,
		DomainList $nameServers = null,
		DnsConfiguration $dnsConfigType = null
	)
	{
		$this->domain = $domain;
		$this->nameServers = $nameServers;
		$this->dnsConfigType = $dnsConfigType;
	}

	public function getKey()
	{
		return $this->domain->getName();
	}

	public function getRequestData()
	{
		return array(
			'domainName' => $this->domain->getName(),
			'nameServers' => isset($this->nameServers) ? $this->nameServers->getDomainNames() : null,
			'dnsConfigType' => $this->dnsConfigType->getConfig()
		);
	}
}
