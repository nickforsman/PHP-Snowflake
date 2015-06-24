<?php

use Snowflake/Http/Request;

class Snowflake 
{

    const VERSION = '0.0.1'; 

    protected $request;

    public function __construct() 
    {

    }

    public function start() 
    {
        return $this->reqest->listen('Hello');
    }
}
