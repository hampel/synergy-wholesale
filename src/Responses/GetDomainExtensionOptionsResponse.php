<?php  namespace SynergyWholesale\Responses; 

use SynergyWholesale\Types\Boolean;

class GetDomainExtensionOptionsResponse extends Response
{
	protected $expectedFields = array(
		'canRenew', 'canRenewWithin', 'cannotRenewAfter',
		'isIPV4Capable', 'isIPV6Capable',
		'isIDProtectCapable', 'transferLock', 'isHostsCapable',
		'minYears', 'maxYears'
	);

	public function canRenew()
	{
		return Boolean::convert($this->response->canRenew);
	}

	public function canRenewWithin()
	{
		return intval($this->response->canRenewWithin);
	}

	public function cannotRenewAfter()
	{
		return intval($this->response->cannotRenewAfter);
	}

	public function isIpV4Capable()
	{
		return Boolean::convert($this->response->isIPV4Capable);
	}

	public function isIpv6Capable()
	{
		return Boolean::convert($this->response->isIPV6Capable);
	}

	public function isIdProtectCapable()
	{
		return Boolean::convert($this->response->isIDProtectCapable);
	}

	public function transferLock()
	{
		return Boolean::convert($this->response->transferLock);
	}

	public function isHostsCapable()
	{
		return Boolean::convert($this->response->isHostsCapable);
	}

	public function minYears()
	{
		return intval($this->response->minYears);
	}

	public function maxYears()
	{
		return intval($this->response->maxYears);
	}

	public function dnssecAvailable()
	{
		return $this->response->DNSSECAvailable;
	}

	public function availableContacts()
	{
		return $this->response->availableContacts;
	}

	public function whoisVerification()
	{
		return $this->response->whoisVerification;
	}
}
