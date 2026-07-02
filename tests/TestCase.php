<?php
	namespace YetAnother\Tests;
	
	class TestCase extends \Orchestra\Testbench\TestCase
	{
		protected function setUp(): void
		{
			TestMiddleware::$urlHandled = null;
			parent::setUp();
		}
	}