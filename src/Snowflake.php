<?php

namespace Snowflake\Core;

use Snowflake\Core\Http\Request;

class Snowflake 
{

    const VERSION = '0.0.1'; 

    protected $request;

    public function __construct() 
    {
        $this->request = new Request();
    }

    public function start() 
    {
        $this->request->listen('Hello');
    }

    public function get($uri, $settings) 
    {
        $this->addRoute('GET', $uri $settings);
    }

    protected addRoute()
    {
        
    }

}
