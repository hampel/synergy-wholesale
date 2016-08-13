<?php  namespace SynergyWholesale\Types; 

use SynergyWholesale\Exception\InvalidArgumentException;

class TldPrice
{
	/** @var Tld  */
	protected $tld;
	protected $minPeriod;
	protected $maxPeriod;
	protected $transfer;
	protected $renew;
	protected $redemption;

	/** @var array indexed by year eg $register[1] = first year, $register[5] = fifth year */
	protected $register = [];

	public function __construct(
		Tld $tld,
		$minPeriod,
		$maxPeriod,
		$transfer,
		$renew,
		$redemption,
		array $register
	)
	{
		$minPeriod = intval($minPeriod);
		$maxPeriod = intval($maxPeriod);
		if ($minPeriod <= 0) throw new InvalidArgumentException("minPeriod parameter is required");
		if ($maxPeriod <= 0) throw new InvalidArgumentException("maxPeriod parameter is required");
		if ($maxPeriod < $minPeriod) throw new InvalidArgumentException("maxPeriod should not be less than minPeriod");
		if (!is_numeric($transfer)) throw new InvalidArgumentException("transfer should be numeric");
		if (!is_numeric($renew)) throw new InvalidArgumentException("renew should be numeric");

		if (!is_null($redemption) AND !is_numeric($redemption)) throw new InvalidArgumentException("redemption should be numeric");

		foreach ($register as $index => $price)
		{
			if ($index < $minPeriod) throw new InvalidArgumentException("register year must not be less than {$minPeriod}");
			if ($index > $maxPeriod) throw new InvalidArgumentException("register year must not be more than {$maxPeriod}");
		}

		$this->tld = $tld;
		$this->minPeriod = $minPeriod;
		$this->maxPeriod = $maxPeriod;
		$this->transfer = $transfer;
		$this->renew = $renew;
		$this->redemption = $redemption;
		$this->register = $register;
	}
	public function getTld()
	{
		return $this->tld;
	}

	public function getMinPeriod()
	{
		return $this->minPeriod;
	}

	public function getMaxPeriod()
	{
		return $this->maxPeriod;
	}

	public function getTransfer()
	{
		return $this->transfer;
	}

	public function getRenew()
	{
		return $this->renew;
	}

	public function getRedemption()
	{
		return $this->redemption;
	}

	/**
	 * @return array
	 */
	public function getRegister()
	{
		return $this->register;
	}

}
