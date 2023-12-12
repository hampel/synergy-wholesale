<?php namespace SynergyWholesale\Commands;

class HostingChangePackageCommand implements Command
{
    /** @var string */
    protected $newPlanName;

    /** @var string */
    protected $identifier;

    public function __construct($newPlanName = null, $identifier = null)
    {
        $this->newPlanName = $newPlanName;
        $this->identifier = $identifier;
    }

	public function getRequestData()
	{
		return [
		    'newPlanName' => $this->newPlanName,
            'identifier' => $this->identifier,
        ];
	}

	public function getKey(){}
}
