<?php

use Snowflake\Routing\Router;

class DummyController 
{
    public function index() 
    {
        return "testing index";
    }
}

class RouterTest extends PHPUnit_Framework_TestCase 
{
    private $dummyRoutes = [];
    private $callback;
    
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

        $result = call_user_func($this->dummyRoutes['GET/home']['function']);

        $expected = $this->router->render('GET/home');

        $this->assertEquals($expected, $result);
    }

    public function testExtractsSettingsArrayFromRoute() 
    {
        $this->dummyRoutes = [
            'GET/home' => [
                'method' => 'GET',
                'uri' => '/home',
                'settings' => [
                    'header' => 'Application/json', 
                    'name' => 'home', 
                    'controller' => 'index'
                ],
                'function' => null
            ]
        ];

        $this->router = new Router($this->dummyRoutes);

        $result = $this->router->getRouteSettings('GET/home');

        $expected = ['header' => 'Application/json', 'name' => 'home', 'controller' => 'index'];

        $this->assertEquals($expected, $result);
    }

    public function testInvokesControllerAction() 
    {
        $this->dummyRoutes = [
            'GET/home' => [
                'method' => 'GET',
                'uri' => '/home',
                'settings' => [
                    'controller' => 'DummyController@index'
                ],
                'function' => null
            ]
        ];

        $this->router = new Router($this->dummyRoutes, ['namespace' => '']);

        $expected = $this->router->render('GET/home');
        $result = "testing index";

        $this->assertEquals($expected, $result);
    }
    
    /**
     * @expectedException \Exception
     */
    public function testThrowsExceptionIfNoControllerIsFound() 
    {
        $this->dummyRoutes = [
            'GET/home' => [
                'method' => 'GET',
                'uri' => '/home',
                'settings' => [
                    'controller' => 'asdads@index'
                ],
                'function' => null
            ]
        ];

        $this->router = new Router($this->dummyRoutes, ['namespace' => '']);

        $expected = $this->router->render('GET/home');
        $result = "testing index";

        $this->assertEquals($expected, $result);
    }

    /**
     * @expectedException \Exception
     */
    public function testThrowsExceptionIfClassMethodDoesntExist() 
    {
        $this->dummyRoutes = [
            'GET/home' => [
                'method' => 'GET',
                'uri' => '/home',
                'settings' => [
                    'controller' => 'DummyController@show'
                ],
                'function' => null
            ]
        ];

        $this->router = new Router($this->dummyRoutes, ['namespace' => '']);

        $expected = $this->router->render('GET/home');
        $result = "testing index";

        $this->assertEquals($expected, $result);
    }

}
