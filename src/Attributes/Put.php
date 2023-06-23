<?php
	
	namespace YetAnother\Laravel\Attributes;
	
	use Attribute;
	
	#[Attribute]
	readonly class Put extends Route
	{
		public function __construct(
			string $uri = '',
			?string $name = null,
			?array $where = null)
		{
			parent::__construct('PUT', $uri, $name, $where);
		}
	}
