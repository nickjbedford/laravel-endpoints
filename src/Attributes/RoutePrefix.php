<?php
	
	namespace YetAnother\Laravel\Attributes;
	
	use Attribute;
	
	/**
	 * Attributes a route name prefix to an endpoint class.
	 */
	#[Attribute(Attribute::TARGET_CLASS)]
	readonly class RoutePrefix
	{
		public function __construct(public string $routePrefix)
		{
		}
	}
