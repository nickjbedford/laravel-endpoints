<?php
	
	namespace YetAnother\Laravel\Attributes;
	
	use Attribute;
	
	#[Attribute]
	readonly class RoutePrefix
	{
		public function __construct(public string $prefix)
		{
		}
	}
