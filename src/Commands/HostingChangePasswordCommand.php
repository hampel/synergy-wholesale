<?php namespace SynergyWholesale\Commands;

class HostingChangePasswordCommand implements Command
{
    /** @var string */
    protected $newPassword;

    /** @var string */
    protected $identifier;

    public function __construct($newPassword = null, $identifier = null)
    {
        $this->newPassword = $newPassword;
        $this->identifier = $identifier;
    }

	public function getRequestData()
	{
		return [
		  'newPassword' => $this->newPassword,
      'identifier' => $this->identifier,
    ];
	}

	public function getKey(){}
}
