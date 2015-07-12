<?php

use Snowflake\View\View;

class ViewTest extends PHPUnit_Framework_TestCase 
{
	private $view;

	public function setUp() 
	{
		$this->view = new View(__DIR__ . '/');
	}

	public function testRendersTemplateIfExists() 
	{
		$data = ['name' => 'John'];

		$this->view->render('test.php', $data);
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
