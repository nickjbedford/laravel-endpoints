<?php
	
	namespace YetAnother\Laravel\Attributes;
	
	use Attribute;
	
	/**
	 * Attributes middleware to an endpoint class.
	 */
	#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
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