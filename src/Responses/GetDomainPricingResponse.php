<?php  namespace SynergyWholesale\Responses;

use SynergyWholesale\Types\Tld;
use SynergyWholesale\Types\TldPrice;
use SynergyWholesale\Exception\BadDataException;

class GetDomainPricingResponse extends Response
{
	protected $expectedFields = array('pricing');

	protected $prices;

	protected function validateData()
	{
		if (!is_array($this->response->pricing))
		{
			throw new BadDataException("Expected an array of pricing data");
		}

		foreach ($this->response->pricing as $price)
		{
			$reg = [];
			for ($x = 1; $x <= 10; $x++)
			{
				$key = "register_{$x}_year";
				if (isset($price->$key)) $reg[$x] = $price->$key;
			}

			$this->prices[$price->tld] = new TldPrice(
				new Tld($price->tld),
				$price->minPeriod,
				$price->maxPeriod,
				$price->transfer,
				$price->renew,
				isset($price->redemption) ? $price->redemption : null,
				$reg
			);
		}
	}

	public function getPrices()
	{
		return $this->prices;
	}

	public function getPricing()
	{
		return $this->response->pricing;
	}
}
