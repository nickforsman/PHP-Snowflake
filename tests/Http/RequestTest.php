<?php

use Snowflake\Http\Request;

class RequestTest extends PHPUnit_Framework_TestCase 
{
	public function setUp() 
	{
		$this->method = ['REQUEST_METHOD' => 'GET'];
		$this->request = new Request();
	}

	public function testClassHasSupportedHttpMethods() 
	{
		$this->assertClassHasStaticAttribute('supportedMethods', 'Snowflake\Http\Request');
	}

	public function testClassHasUnSupportedHttpMethods() 
	{
		$this->assertClassHasStaticAttribute('unsupportedMethods', 'Snowflake\Http\Request');
	}

	/**
	 * @expectedException Snowflake\Exceptions\InvalidRequestException
	 */
	public function testChecksThatTheHttpMethodIsAnArray() 
	{
		$this->request->listen('asd');
	}

	/**
	 * @expectedException Snowflake\Exceptions\UnsupportedMethodException
	 */ 
	public function testThrowExceptionIfHttpMethodIsNotSupported() 
	{
		$this->request->listen(['REQUEST_METHOD' => 'PATCH']);
	}

	/**
	 * @expectedException \Exception
	 */ 
	public function testThrowExceptionIfNonHttpMethodIsDetected()
	{
		$this->request->listen(['REQUEST_METHOD' => 'RANDOM']);
	}

	public function testChecksThatTheGivenHttpMethodIsSupported() 
	{
		$this->assertContains($this->method['REQUEST_METHOD'], Request::$supportedMethods);
	}
}