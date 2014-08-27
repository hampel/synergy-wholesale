<?php  namespace SynergyWholesale\Commands;

use SynergyWholesale\Types\Domain;

class ListContactsCommand implements Command
{
	protected $domain;

	public function __construct(Domain $domain)
	{
		$this->domain = $domain;
	}

	public function getRequestData()
	{
		return array('domainName' => strval($this->domain));
	}
}

?>
 