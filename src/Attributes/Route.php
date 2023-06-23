<?php
	namespace YetAnother\Laravel\Attributes;
	
	use Attribute;
	
	#[Attribute]
	readonly class Route
	{
		public function __construct(
			public string|array $methods,
			public string $uri,
			public ?string $name = null,
			public ?array $where = null,
		)
		{
		}
	}
