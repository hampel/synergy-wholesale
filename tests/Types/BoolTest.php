<?php  namespace SynergyWholesale\Types; 

class BoolTest extends \PHPUnit_Framework_TestCase
{
	public function testBool()
	{
		$this->assertTrue((new Boolean('y'))->getBool());
		$this->assertTrue((new Boolean('Y'))->getBool());
		$this->assertTrue((new Boolean('yes'))->getBool());
		$this->assertTrue((new Boolean('Yes'))->getBool());
		$this->assertTrue((new Boolean('YES'))->getBool());
		$this->assertTrue((new Boolean('on'))->getBool());
		$this->assertTrue((new Boolean('On'))->getBool());
		$this->assertTrue((new Boolean('ON'))->getBool());
		$this->assertTrue((new Boolean('t'))->getBool());
		$this->assertTrue((new Boolean('T'))->getBool());
		$this->assertTrue((new Boolean('true'))->getBool());
		$this->assertTrue((new Boolean('True'))->getBool());
		$this->assertTrue((new Boolean('TRUE'))->getBool());
		$this->assertTrue((new Boolean('enabled'))->getBool());
		$this->assertTrue((new Boolean('Enabled'))->getBool());
		$this->assertTrue((new Boolean('ENABLED'))->getBool());
		$this->assertTrue((new Boolean('1'))->getBool());

		$this->assertFalse((new Boolean('n'))->getBool());
		$this->assertFalse((new Boolean('n'))->getBool());
		$this->assertFalse((new Boolean('no'))->getBool());
		$this->assertFalse((new Boolean('No'))->getBool());
		$this->assertFalse((new Boolean('NO'))->getBool());
		$this->assertFalse((new Boolean('off'))->getBool());
		$this->assertFalse((new Boolean('Off'))->getBool());
		$this->assertFalse((new Boolean('OFF'))->getBool());
		$this->assertFalse((new Boolean('f'))->getBool());
		$this->assertFalse((new Boolean('F'))->getBool());
		$this->assertFalse((new Boolean('false'))->getBool());
		$this->assertFalse((new Boolean('False'))->getBool());
		$this->assertFalse((new Boolean('FALSE'))->getBool());
		$this->assertFalse((new Boolean('disabled'))->getBool());
		$this->assertFalse((new Boolean('Disabled'))->getBool());
		$this->assertFalse((new Boolean('DISABLED'))->getBool());
		$this->assertFalse((new Boolean('0'))->getBool());

		$this->assertTrue(Boolean::true()->getBool());
		$this->assertFalse(Boolean::false()->getBool());

		$this->assertTrue(Boolean::true()->isTrue());
		$this->assertTrue(Boolean::false()->isFalse());

		$this->assertEquals('true', strval(Boolean::true()));
		$this->assertEquals('false', strval(Boolean::false()));

		$this->assertTrue(Boolean::convert('yes'));
		$this->assertFalse(Boolean::convert('no'));
	}
}
