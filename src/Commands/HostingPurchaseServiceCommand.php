<?php namespace SynergyWholesale\Commands;

class HostingPurchaseServiceCommand implements Command
{
    /** @var string */
    protected $planName;

    /** @var string */
    protected $domain;

    /** @var string */
    protected $email;

    /** @var string */
    protected $username;

    /** @var string */
    protected $password;
    
    /** @var string */
    protected $firstName;

    /** @var string */
    protected $lastName;

    public function __construct($planName = null, $domain = null, $email = null, $username = null, $password = null, $firstName = null, $lastName = null)
    {
        $this->planName = $planName;
        $this->domain = $domain;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

	public function getRequestData()
	{
		return [
		  'planName' => $this->planName,
          'domain' => $this->domain,
          'email' => $this->email,
          'username' => $this->username,
          'password' => $this->password,
          'firstName' => $this->firstName,
          'lastName' => $this->lastName,
        ];
	}

	public function getKey(){}
}
