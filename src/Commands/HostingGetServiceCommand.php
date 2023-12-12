<?php namespace SynergyWholesale\Commands;

class HostingGetServiceCommand implements Command
{
    /** @var string */
    protected $identifier;

    public function __construct($identifier = null)
    {
        $this->identifier = $identifier;
    }

	public function getRequestData()
	{
		return [
		  'identifier' => $this->identifier,
        ];
	}

	public function getKey(){}
}
