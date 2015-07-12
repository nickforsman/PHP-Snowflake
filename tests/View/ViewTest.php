<?php

use Snowflake\View\View;

class ViewTest extends PHPUnit_Framework_TestCase 
{
	private $view;

	public function setUp() 
	{
		$this->view = new View;
	}

	public function testRendersTemplateIfExists() 
	{
		$data = ['name' => 'John'];

		$this->view->render('hello.php', $data);
	}

	/**
     * @expectedException \InvalidArgumentException
     */
	public function testThrowsExceptionIfTemplateFileNotFound() 
	{
		$data = ['name' => 'John'];

		$this->view->render('heo.php', $data);
	}

}
