<?php namespace SynergyWholesale\Commands;

use SynergyWholesale\Types\AuState;

class BusinessCheckRegistrationCommand implements Command
{
	/** @var string $registrationNumber */
	protected $registrationNumber;

	/** @var \SynergyWholesale\Types\AuState $registrationState */
	protected $registrationState;

	public function __construct($registrationNumber, AuState $registrationState = null)
	{
		$this->registrationNumber = $registrationNumber;
		$this->registrationState = $registrationState;
	}

	public function getKey()
	{
		return $this->registrationNumber . ($this->registrationState ? $this->registrationState->getState() : '');
	}

	public function getRequestData()
	{
		$data = array('registrationNumber' => $this->registrationNumber);

		if (isset($this->registrationState))
		{
			$data['registrationState'] = $this->registrationState->getState();
		}

		return $data;
	}
}
