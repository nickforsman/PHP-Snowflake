<?php

use Snowflake\Helpers\Input;

class InputTest extends PHPUnit_Framework_TestCase 
{
    private $input;

    public function setUp() 
    {
        $this->input = new Input();
    }

    public function testLoadsGlobals() 
    {
        $expected = $_POST['email'] = "test@example.com";
        $this->input->createFromGlobals();

        $this->assertEquals($expected, $this->input->post('email'));
    }

    public function testLoadsAttributeKey() 
    {
        $_COOKIE['email'] = "test@example.com";
        $this->input->createFromGlobals();

        $expected = ['email' => "test@example.com"];
        $result = $this->input->key('cookie');

        $this->assertSame($expected, $result);
    }

}
