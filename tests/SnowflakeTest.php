<?php

use Snowflake\Snowflake;

/**
 *  @coversDefaultClass \Snowflake\Snowflake
 */
class SnowflakeTest extends PHPUnit_Framework_TestCase 
{
	private $app;

	public function setUp() 
	{
		$this->app = new Snowflake();
	}

	public function testAddsRouteToRoutes() 
	{
		$this->app->get('/home', ['controller' => 'HomeController@show']);
		$expected = ['method' => 'GET', 'uri' => '/home', 'settings' => ['controller' => 'HomeController@show'], 'function' => null];
		$this->assertSame($this->app->routes['GET/home'], $expected);
	}
	
	/**
     * @expectedException \InvalidArgumentException
     */
	public function testThrowsExceptionIfControllerAndCallbackIsSet() 
	{
		$callback = function() {};
		$this->app->get('/home', ['controller' => 'HomeController@show'], $callback);
		$expected = ['method' => 'GET', 'uri' => '/home', 'settings' => ['controller' => 'HomeController@show'], 'function' => $callback];
		$this->assertSame($this->app->routes['GET/home'], $expected);
	}

	public function testLoadsConfigurationFromConfig() 
	{
		$this->app->config = [
			'db' => [
				'driver' => 'mysql',
			]
		];
		$result = $this->app->load('db', 'driver');
		$this->assertEquals('mysql', $result);
	}
	
	/**
     * @expectedException \Exception
     */
	public function testThrowsExceptionIfConfigKeyIsNotFound() 
	{
		$this->app->config = [
			'db' => [
				'driver' => 'mysql',
			]
		];
		$result = $this->app->load('dd', 'driver');
		$this->assertEquals('mysql', $result);
	}

	/**
     * @expectedException \Exception
     */
	public function testThrowsExceptionIfConfigPropertyIsNotSet() 
	{
		$this->app->config = [
			'db' => [
				'driver' => 'mysql',
			]
		];
		$result = $this->app->load('db', 'drver');
		$this->assertEquals('mysql', $result);
	}

	public function ReturnsNullIfNoRouteIsFound() 
	{
		$this->assertNull($this->app->dispatch($_SERVER));
	}

	public function testReturnsRouteIfSet() 
	{
		$method = $_SERVER['REQUEST_METHOD'] = 'POST';
		$uri = $_SERVER['REQUEST_URI'] = '/main';
		$host = $_SERVER['HTTP_HOST'] = 'localhost';
		$this->app->routes = ['POST/main' => []];
		$expected = 'POST/main';
		$this->assertEquals($expected, $this->app->dispatch($_SERVER));
	}
}
