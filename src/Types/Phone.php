<?php  namespace SynergyWholesale\Types; 

use SynergyWholesale\Exception\InvalidArgumentException;

class Phone
{
	/** @var string */
	private $phone;

	function __construct($phone)
	{
		// strip all spaces
		$phone = str_replace(' ', '', strval($phone));

		if (!preg_match('/^\+[0-9]{1,3}\.[0-9]{6,12}$/', $phone))
		{
			throw new InvalidArgumentException("Invalid phone number [{$phone}] - must be in the format +99.9999999999");
		}
		$this->phone = $phone;
	}

	/**
	 * @return string
	 */
	public function getPhone()
	{
		return $this->phone;
	}

	public function __toString()
	{
		return $this->getPhone();
	}

	public function equals(Phone $other)
	{
		return $this->phone === $other->phone;
	}
}
