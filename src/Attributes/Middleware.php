<?php
	
	namespace YetAnother\Laravel\Attributes;
	
	use Attribute;
	
	#[Attribute]
	readonly class Middleware
	{
		public array $middleware;
		
		/**
		 * @param string ...$middleware
		 */
		public function __construct(...$middleware)
		{
			$this->middleware = $middleware;
		}
	}
