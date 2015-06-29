<?php

use Snowflake\Routing\Router;

class RouterTest extends PHPUnit_Framework_TestCase 
{
    private $dummyRoutes = [];
    private $callback;
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowsExceptionIfBothAControllerAndACallbackIsSet() 
    {
        $this->callback = function() {};

        $this->dummyRoutes = [
            'GET/home' => [
                'method' => 'GET',
                'uri' => '/home',
                'settings' => [
                    'controller' => 'HomeController@index'
                ],
                'function' => $this->callback
            ]
        ];

        $this->router = new Router($this->dummyRoutes);

        $this->router->render('GET/home');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowsExceptionIfNoControllerOrCallbackSet() 
    {
        $this->dummyRoutes = [
            'GET/home' => [
                'method' => 'GET',
                'uri' => '/home',
                'settings' => [],
            ]
        ];

        $this->router = new Router($this->dummyRoutes);

        $this->router->render('GET/home');
    }

    public function testInvokesCallbackIfPresentInRoute() 
    {

        $this->callback = function() {
            return "Moi";
        };

        $this->dummyRoutes = [
            'GET/home' => [
                'method' => 'GET',
                'uri' => '/home',
                'settings' => [],
                'function' => $this->callback
            ]
        ];

        $this->router = new Router($this->dummyRoutes);

        if (isset($this->dummyRoutes['GET/home']['function'])) {
            $result = call_user_func($this->dummyRoutes['GET/home']['function']);
        }

        $expected = $this->router->render('GET/home');

        $this->assertEquals($expected, $result);
    }

}
