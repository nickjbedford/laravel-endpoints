<?php
	
	namespace YetAnother\Laravel\Attributes;
	
	use Attribute;
	
	/**
	 * Attributes a route name prefix to an endpoint class.
	 */
	#[Attribute]
	readonly class RoutePrefix
	{
		public function __construct(public string $prefix)
		{
		}
	}
