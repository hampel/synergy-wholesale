<?php namespace SynergyWholesale\Commands;

class HostingListPackagesCommand implements Command
{
    /** @var string */
    protected $product;

    public function __construct($product = null)
    {
        $this->product = $product;
    }

	public function getRequestData()
	{
		return [
		  'product' => $this->product,
    ];
	}

	public function getKey(){}
}
