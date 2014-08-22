<?php  namespace SynergyWholesale\Types;

use SynergyWholesale\Exception\UnknownStateException;

class AuState
{
	private $state;

	private $states = array('NSW', 'VIC', 'QLD', 'TAS', 'ACT', 'SA', 'WA', 'NT');

	public function __construct($state)
	{
		$state = strtoupper($state);
		if (!in_array($state, $this->states))
		{
			throw new UnknownStateException("Unknown state [{$state}]");
		}
		$this->state = $state;
	}

	public function getState()
	{
		return $this->state;
	}

	public function __toString()
	{
		return $this->getState();
	}
}

?>
 