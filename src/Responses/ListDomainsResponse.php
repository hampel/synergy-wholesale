<?php  namespace SynergyWholesale\Responses;

use SynergyWholesale\Exception\BadDataException;

class ListDomainsResponse extends Response
{
//	protected $expectedFields = array('page', 'limit');

    // TODO - handle case where page returns no results

//	protected function validateData()
//	{
//		if (!is_array($this->response->domainList))
//		{
//			throw new BadDataException("Expected an array of domains");
//		}
//	}

	public function getDomainList()
	{
		return $this->response->domainList;
	}

	public function getPage()
    {
        return $this->response->page;
    }

    public function getLimit()
    {
        return $this->response->limit;
    }
}
