<?php namespace SynergyWholesale\Commands;

class ListHostingCommand implements Command
{
    /** @var int */
    protected $page;

    /** @var int */
    protected $limit;

    /** @var string */
    protected $status;

    public function __construct($page = null, $limit = null, $status = null)
    {
        $this->page = $page;
        $this->limit = $limit;
        $this->status = $status;
    }

	public function getRequestData()
	{
		return [
		  'page' => $this->page,
          'limit' => $this->limit,
          'status' => $this->status
        ];
	}

	public function getKey(){}
}
