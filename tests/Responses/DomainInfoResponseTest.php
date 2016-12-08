<?php  namespace SynergyWholesale\Responses; 

use stdClass;
use SynergyWholesale\Types\DnsConfiguration;

class DomainInfoResponseTest extends \PHPUnit_Framework_TestCase
{
	public function testMissingDomainName()
	{
		$data = new stdClass();
		$data->status = "OK";

		$this->setExpectedException('SynergyWholesale\Exception\BadDataException', 'Expected property [domainName] missing from response data');

		new DomainInfoResponse($data, 'DomainInfoCommand');
	}

	public function testMissingDomainStatus()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->domainName = '';

		$this->setExpectedException('SynergyWholesale\Exception\BadDataException', 'Expected property [domain_status] missing from response data');

		new DomainInfoResponse($data, 'DomainInfoCommand');
	}

	public function testMissingDomainExpiry()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->domainName = '';
		$data->domain_status = '';

		$this->setExpectedException('SynergyWholesale\Exception\BadDataException', 'Expected property [domain_expiry] missing from response data');

		new DomainInfoResponse($data, 'DomainInfoCommand');
	}

	public function testMissingNameServers()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->domainName = '';
		$data->domain_status = '';
		$data->domain_expiry = '';

		$this->setExpectedException('SynergyWholesale\Exception\BadDataException', 'Expected property [nameServers] missing from response data');

		new DomainInfoResponse($data, 'DomainInfoCommand');
	}

	public function testMissingDnsConfig()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->domainName = '';
		$data->domain_status = '';
		$data->domain_expiry = '';
		$data->nameServers = '';

		$this->setExpectedException('SynergyWholesale\Exception\BadDataException', 'Expected property [dnsConfig] missing from response data');

		new DomainInfoResponse($data, 'DomainInfoCommand');
	}

	public function testMissingDnsConfigName()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->domainName = '';
		$data->domain_status = '';
		$data->domain_expiry = '';
		$data->nameServers = '';
		$data->dnsConfig = '';

		$this->setExpectedException('SynergyWholesale\Exception\BadDataException', 'Expected property [dnsConfigName] missing from response data');

		new DomainInfoResponse($data, 'DomainInfoCommand');
	}

	public function testMissingDomainPassword()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->domainName = 'example.com';
		$data->domain_status = '';
		$data->domain_expiry = '';
		$data->nameServers = ['ns1.example.com', 'ns2.example.com'];
		$data->dnsConfig = '';
		$data->dnsConfigName = '';
		$data->bulkInProgress = '';
		$data->idProtect = '';
		$data->autoRenew = '';
		$data->icannStatus = '';
		$data->icannVerificationDateEnd = '';

		$this->setExpectedException('SynergyWholesale\Exception\BadDataException', 'Expected property [domainPassword] missing from response data');

		new DomainInfoResponse($data, 'DomainInfoCommand');
	}

	public function testMissingDomainPasswordUk()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->domainName = 'example.co.uk';
		$data->domain_status = '';
		$data->domain_expiry = '';
		$data->nameServers = ['ns1.example.com', 'ns2.example.com'];
		$data->dnsConfig = DnsConfiguration::PARKED;
		$data->dnsConfigName = '';
		$data->bulkInProgress = '';
		$data->idProtect = '';
		$data->autoRenew = '';
		$data->icannStatus = '';
		$data->icannVerificationDateEnd = '';

		new DomainInfoResponse($data, 'DomainInfoCommand');
	}

	public function testMissingBulkInProgress()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->domainName = '';
		$data->domain_status = '';
		$data->domain_expiry = '';
		$data->nameServers = '';
		$data->dnsConfig = '';
		$data->dnsConfigName = '';
		$data->domainPassword = '';

		$this->setExpectedException('SynergyWholesale\Exception\BadDataException', 'Expected property [bulkInProgress] missing from response data');

		new DomainInfoResponse($data, 'DomainInfoCommand');
	}

	public function testMissingIdProtect()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->domainName = '';
		$data->domain_status = '';
		$data->domain_expiry = '';
		$data->nameServers = '';
		$data->dnsConfig = '';
		$data->dnsConfigName = '';
		$data->domainPassword = '';
		$data->bulkInProgress = '';

		$this->setExpectedException('SynergyWholesale\Exception\BadDataException', 'Expected property [idProtect] missing from response data');

		new DomainInfoResponse($data, 'DomainInfoCommand');
	}

	public function testMissingAutoRenew()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->domainName = '';
		$data->domain_status = '';
		$data->domain_expiry = '';
		$data->nameServers = '';
		$data->dnsConfig = '';
		$data->dnsConfigName = '';
		$data->domainPassword = '';
		$data->bulkInProgress = '';
		$data->idProtect = '';

		$this->setExpectedException('SynergyWholesale\Exception\BadDataException', 'Expected property [autoRenew] missing from response data');

		new DomainInfoResponse($data, 'DomainInfoCommand');
	}

	public function testMissingIcannStatus()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->domainName = '';
		$data->domain_status = '';
		$data->domain_expiry = '';
		$data->nameServers = '';
		$data->dnsConfig = '';
		$data->dnsConfigName = '';
		$data->domainPassword = '';
		$data->bulkInProgress = '';
		$data->idProtect = '';
		$data->autoRenew = '';

		$this->setExpectedException('SynergyWholesale\Exception\BadDataException', 'Expected property [icannStatus] missing from response data');

		new DomainInfoResponse($data, 'DomainInfoCommand');
	}

	public function testMissingIcannVerificationDateEnd()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->domainName = '';
		$data->domain_status = '';
		$data->domain_expiry = '';
		$data->nameServers = '';
		$data->dnsConfig = '';
		$data->dnsConfigName = '';
		$data->domainPassword = '';
		$data->bulkInProgress = '';
		$data->idProtect = '';
		$data->autoRenew = '';
		$data->icannStatus = '';

		$this->setExpectedException('SynergyWholesale\Exception\BadDataException', 'Expected property [icannVerificationDateEnd] missing from response data');

		new DomainInfoResponse($data, 'DomainInfoCommand');
	}

	public function testBadDomain()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->domainName = 'foo';
		$data->domain_status = '';
		$data->domain_expiry = '';
		$data->nameServers = array();
		$data->dnsConfig = '';
		$data->dnsConfigName = '';
		$data->domainPassword = '';
		$data->bulkInProgress = '';
		$data->idProtect = '';
		$data->autoRenew = '';
		$data->icannStatus = '';
		$data->icannVerificationDateEnd = '';

		$this->setExpectedException('SynergyWholesale\Exception\BadDataException', 'Invalid domain name [foo]');

		new DomainInfoResponse($data, 'DomainInfoCommand');
	}

	public function testNameServersNotArray()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->domainName = 'foo.com.au';
		$data->domain_status = '';
		$data->domain_expiry = '';
		$data->nameServers = '';
		$data->dnsConfig = '';
		$data->dnsConfigName = '';
		$data->domainPassword = '';
		$data->bulkInProgress = '';
		$data->idProtect = '';
		$data->autoRenew = '';
		$data->icannStatus = '';
		$data->icannVerificationDateEnd = '';

		$this->setExpectedException('SynergyWholesale\Exception\BadDataException', 'nameServers should be an array');

		new DomainInfoResponse($data, 'DomainInfoCommand');
	}

	public function testMissingAuRegistrantName()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->domainName = 'foo.com.au';
		$data->domain_status = '';
		$data->domain_expiry = '';
		$data->nameServers = array();
		$data->dnsConfig = '';
		$data->dnsConfigName = '';
		$data->domainPassword = '';
		$data->bulkInProgress = '';
		$data->idProtect = '';
		$data->autoRenew = '';
		$data->icannStatus = '';
		$data->icannVerificationDateEnd = '';

		$this->setExpectedException('SynergyWholesale\Exception\BadDataException', 'Expected property [auRegistrantName] missing from response data');

		new DomainInfoResponse($data, 'DomainInfoCommand');
	}

	public function testMissingAuRegistrantID()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->domainName = 'foo.com.au';
		$data->domain_status = '';
		$data->domain_expiry = '';
		$data->nameServers = array();
		$data->dnsConfig = '';
		$data->dnsConfigName = '';
		$data->domainPassword = '';
		$data->bulkInProgress = '';
		$data->idProtect = '';
		$data->autoRenew = '';
		$data->icannStatus = '';
		$data->icannVerificationDateEnd = '';
		$data->auRegistrantName = '';

		$this->setExpectedException('SynergyWholesale\Exception\BadDataException', 'Expected property [auRegistrantID] or [auEligibilityID] missing from response data');

		new DomainInfoResponse($data, 'DomainInfoCommand');
	}

	public function testMissingAuRegistrantIDType()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->domainName = 'foo.com.au';
		$data->domain_status = '';
		$data->domain_expiry = '';
		$data->nameServers = array();
		$data->dnsConfig = '';
		$data->dnsConfigName = '';
		$data->domainPassword = '';
		$data->bulkInProgress = '';
		$data->idProtect = '';
		$data->autoRenew = '';
		$data->icannStatus = '';
		$data->icannVerificationDateEnd = '';
		$data->auRegistrantName = '';
		$data->auRegistrantID = '';

		$this->setExpectedException('SynergyWholesale\Exception\BadDataException', 'Expected property [auRegistrantIDType] or [auEligibilityIDType] missing from response data');

		new DomainInfoResponse($data, 'DomainInfoCommand');
	}

	public function testMissingAuEligibilityType()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->domainName = 'foo.id.au';
		$data->domain_status = '';
		$data->domain_expiry = '';
		$data->nameServers = array();
		$data->dnsConfig = '';
		$data->dnsConfigName = '';
		$data->domainPassword = '';
		$data->bulkInProgress = '';
		$data->idProtect = '';
		$data->autoRenew = '';
		$data->icannStatus = '';
		$data->icannVerificationDateEnd = '';
		$data->auRegistrantName = '';

		$this->setExpectedException('SynergyWholesale\Exception\BadDataException', 'Expected property [auEligibilityType] missing from response data');

		new DomainInfoResponse($data, 'DomainInfoCommand');
	}

	public function testBadDnsConfig()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->domainName = 'foo.com.au';
		$data->domain_status = '';
		$data->domain_expiry = '';
		$data->nameServers = array();
		$data->dnsConfig = 'foo';
		$data->dnsConfigName = '';
		$data->domainPassword = '';
		$data->bulkInProgress = '';
		$data->idProtect = '';
		$data->autoRenew = '';
		$data->icannStatus = '';
		$data->icannVerificationDateEnd = '';
		$data->auRegistrantID = '';
		$data->auRegistrantIDType = '';
		$data->auRegistrantName = '';

		$this->setExpectedException('SynergyWholesale\Exception\BadDataException', 'Unknown DNS Configuration [foo]');

		new DomainInfoResponse($data, 'DomainInfoCommand');
	}

	public function testIdAuResponse()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->domainName = 'foo.id.au';
		$data->domain_status = 'domain_status';
		$data->domain_expiry = 'domain_expiry';
		$data->nameServers = array(
			'ns1.foo.com',
			'ns2.foo.com'
		);
		$data->dnsConfig = '1';
		$data->dnsConfigName = 'dnsConfigName';
		$data->domainPassword = 'domainPassword';
		$data->bulkInProgress = '1';
		$data->idProtect = 'Enabled';
		$data->autoRenew = 'on';
		$data->icannStatus = 'icannStatus';
		$data->icannVerificationDateEnd = 'icannVerificationDateEnd';
		$data->auRegistrantName = 'auRegistrantName';
		$data->auEligibilityType = 'auEligibilityType';
		$data->auPolicyID = 'auPolicyID';
		$data->auPolicyIDDesc = 'auPolicyIDDesc';

		$response = new DomainInfoResponse($data, 'DomainInfoCommand');

		$this->assertEquals('foo.id.au', $response->getDomainName());
	}

	public function testResponse()
	{
		$data = new stdClass();
		$data->status = "OK";
		$data->domainName = 'foo.com.au';
		$data->domain_status = 'domain_status';
		$data->domain_expiry = 'domain_expiry';
		$data->nameServers = array(
			'ns1.foo.com',
			'ns2.foo.com'
		);
		$data->dnsConfig = '1';
		$data->dnsConfigName = 'dnsConfigName';
		$data->domainPassword = 'domainPassword';
		$data->bulkInProgress = '1';
		$data->idProtect = 'Enabled';
		$data->autoRenew = 'on';
		$data->icannStatus = 'icannStatus';
		$data->icannVerificationDateEnd = 'icannVerificationDateEnd';
		$data->auRegistrantID = 'auRegistrantID';
		$data->auRegistrantIDType = 'auRegistrantIDType';
		$data->auRegistrantName = 'auRegistrantName';
		$data->auEligibilityName = 'auEligibilityName';
		$data->auEligibilityID = 'auEligibilityID';
		$data->auEligibilityType = 'auEligibilityType';
		$data->auEligibilityIDType = 'auEligibilityIDType';
		$data->auPolicyID = 'auPolicyID';
		$data->auPolicyIDDesc = 'auPolicyIDDesc';

		$response = new DomainInfoResponse($data, 'DomainInfoCommand');

		$this->assertEquals('foo.com.au', $response->getDomainName());
		$this->assertEquals('domain_status', $response->getDomainStatus());
		$this->assertEquals('domain_expiry', $response->getDomainExpiry());
		$this->assertTrue(is_array($response->getNameServers()));
		$this->assertArrayHasKey(0, $response->getNameServers());
		$this->assertEquals('ns1.foo.com', $response->getNameServers()[0]);
		$this->assertArrayHasKey(1, $response->getNameServers());
		$this->assertEquals('ns2.foo.com', $response->getNameServers()[1]);
		$this->assertEquals(1, $response->getDnsConfig());
		$this->assertEquals('dnsConfigName', $response->getDnsConfigName());
		$this->assertEquals('domainPassword', $response->getDomainPassword());
		$this->assertTrue($response->isBulkInProgress());
		$this->assertEquals('Enabled', $response->getIdProtected());
		$this->assertTrue($response->isAutoRenewEnabled());
		$this->assertEquals('auRegistrantIDType', $response->getAuRegistrantIdType());
		$this->assertEquals('auRegistrantID', $response->getAuRegistrantId());
		$this->assertEquals('auRegistrantName', $response->getAuRegistrantName());
		$this->assertEquals('auEligibilityName', $response->getAuEligibilityName());
		$this->assertEquals('auEligibilityID', $response->getAuEligibilityID());
		$this->assertEquals('auEligibilityType', $response->getAuEligibilityType());
		$this->assertEquals('auEligibilityIDType', $response->getAuEligibilityIDType());
		$this->assertEquals('auPolicyID', $response->getAuPolicyID());
		$this->assertEquals('auPolicyIDDesc', $response->getAuPolicyIDDesc());
		$this->assertEquals('icannStatus', $response->getIcannStatus());
		$this->assertEquals('icannVerificationDateEnd', $response->getIcannVerificationDateEnd());
	}


}
