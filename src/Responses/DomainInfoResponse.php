<?php  namespace SynergyWholesale\Responses;

use SynergyWholesale\Types\Boolean;
use SynergyWholesale\Types\Domain;
use SynergyWholesale\Types\DomainList;
use SynergyWholesale\Types\DnsConfiguration;
use SynergyWholesale\Exception\BadDataException;
use SynergyWholesale\Exception\InvalidArgumentException;
use SynergyWholesale\Exception\UnknownDnsConfigurationException;

class DomainInfoResponse extends Response
{
	protected $expectedFields = array(
		'domainName', 'domain_status', 'domain_expiry',
		'nameServers', 'dnsConfig', 'dnsConfigName',
		'bulkInProgress', 'idProtect', 'autoRenew',
		'icannStatus', 'icannVerificationDateEnd'
	);

	/** @var Domain */
	protected $domain;

	/** @var DomainList */
	protected $nameServers;

	protected function validateData()
	{
		if (!is_array($this->response->nameServers))
		{
			$message = "nameServers should be an array";
			throw new BadDataException($message, $this->command, $this->response);
		}

		try
		{
			$this->domain = new Domain($this->response->domainName);
			if (!empty($this->response->nameServers))
			{
				$this->nameServers = new DomainList($this->response->nameServers);
			}
		}
		catch (InvalidArgumentException $e)
		{
			throw new BadDataException($e->getMessage(), $this->command, $this->response);
		}

		if ($this->domain->getTopLevelDomain() == 'au')
		{
			if (!isset($this->response->auRegistrantName))
			{
				$message = "Expected property [auRegistrantName] missing from response data";
				throw new BadDataException($message, $this->command, $this->response);
			}

			if ($this->domain->getExtension() == 'id.au') // applies only to .id.au domains
			{
				if (!isset($this->response->auEligibilityType))
				{
					$message = "Expected property [auEligibilityType] missing from response data";
					throw new BadDataException($message, $this->command, $this->response);
				}
			}
			else
			{
				if (!isset($this->response->auRegistrantID) AND !isset($this->response->auEligibilityID))
				{
					$message = "Expected property [auRegistrantID] or [auEligibilityID] missing from response data";
					throw new BadDataException($message, $this->command, $this->response);
				}

				if (!isset($this->response->auRegistrantIDType) AND !isset($this->response->auEligibilityIDType))
				{
					$message = "Expected property [auRegistrantIDType] or [auEligibilityIDType] missing from response data";
					throw new BadDataException($message, $this->command, $this->response);
				}
			}
		}

		if ($this->domain->getTopLevelDomain() != 'uk')
		{
			if (!isset($this->response->domainPassword))
			{
				$message = "Expected property [domainPassword] missing from response data";
				throw new BadDataException($message, $this->command, $this->response);
			}
		}

		try
		{
			new DnsConfiguration($this->response->dnsConfig);
		}
		catch (UnknownDnsConfigurationException $e)
		{
			throw new BadDataException($e->getMessage(), $this->command, $this->response);
		}
	}

	/**
	 * @return Domain
	 */
	public function getDomain()
	{
		return $this->domain;
	}

	/**
	 * @return string domain name
	 */
	public function getDomainName()
	{
		return $this->response->domainName;
	}

	/**
	 * @return string domain status
	 */
	public function getDomainStatus()
	{
		return $this->response->domain_status;
	}

	/**
	 * @return string domain expiry
	 */
	public function getDomainExpiry()
	{
		return $this->response->domain_expiry;
	}

	/**
	 * @return string[] array of name server strings
	 */
	public function getNameServers()
	{
		if (isset($this->nameServers))
		{
			return $this->nameServers->getDomainNames();
		}
	}

	/**
	 * @return Domain[] array of Domain types
	 */
	public function getNameServerList()
	{
		if (isset($this->nameServers))
		{
			return $this->nameServers->getDomainList();
		}
	}

	public function getDnsConfig()
	{
		return $this->response->dnsConfig;
	}

	public function getDnsConfigName()
	{
		return $this->response->dnsConfigName;
	}

	public function getDomainPassword()
	{
		return $this->response->domainPassword;
	}

	public function isBulkInProgress()
	{
		return Boolean::convert($this->response->bulkInProgress);
	}

	public function getIdProtected()
	{
		return $this->response->idProtect;
	}

	public function isAutoRenewEnabled()
	{
		return Boolean::convert($this->response->autoRenew);
	}

	public function getAuRegistrantIdType()
	{
		if (isset($this->response->auRegistrantIDType))
		{
			return $this->response->auRegistrantIDType;
		}
	}

	public function getAuRegistrantId()
	{
		if (isset($this->response->auRegistrantID))
		{
			return $this->response->auRegistrantID;
		}
	}

	public function getAuRegistrantName()
	{
		if (isset($this->response->auRegistrantName))
		{
			return $this->response->auRegistrantName;
		}
	}

	public function getAuEligibilityName()
	{
		if (isset($this->response->auEligibilityName))
		{
			return $this->response->auEligibilityName;
		}
	}

	public function getAuEligibilityID()
	{
		if (isset($this->response->auEligibilityID))
		{
			return $this->response->auEligibilityID;
		}
	}

	public function getAuEligibilityType()
	{
		if (isset($this->response->auEligibilityType))
		{
			return $this->response->auEligibilityType;
		}
	}

	public function getAuEligibilityIDType()
	{
		if (isset($this->response->auEligibilityIDType))
		{
			return $this->response->auEligibilityIDType;
		}
	}

	public function getAuPolicyID()
	{
		if (isset($this->response->auPolicyID))
		{
			return $this->response->auPolicyID;
		}
	}

	public function getAuPolicyIDDesc()
	{
		if (isset($this->response->auPolicyIDDesc))
		{
			return $this->response->auPolicyIDDesc;
		}
	}

	public function getIcannStatus()
	{
		return $this->response->icannStatus;
	}

	public function getIcannVerificationDateEnd()
	{
		return $this->response->icannVerificationDateEnd;
	}
}
