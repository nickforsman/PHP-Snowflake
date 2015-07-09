<?php

use Snowflake\Ioc;

class NullObject 
{
	function __construct() {}
}

class IocTest extends PHPUnit_Framework_TestCase 
{
	private $container;

	public function setUp() 
	{
		$this->container = new Ioc();

		Ioc::register('NullObject', function() {
			return new NullObject();
		});
	}

	public function testClassHasStaticDataProperty() 
	{
		$this->assertClassHasStaticAttribute('data', 'Snowflake\Ioc');
	}

	public function testAddsDependencyToContainer() 
	{
		$this->assertTrue(array_key_exists('NullObject', PHPUnit_Framework_Assert::readAttribute($this->container, 'data')));
	}

	public function testResolvesDependencyFromContainer() 
	{
		$object = $this->container->resolve('NullObject');

		$this->assertTrue($object instanceof NullObject);
	}
}
