<?php
	
	namespace YetAnother\Laravel\Attributes;
	
	use Attribute;
	
	#[Attribute]
	readonly class Patch extends Route
	{
		public function __construct(
			string $uri = '',
			?string $name = null,
			?array $where = null)
		{
			parent::__construct('PATCH', $uri, $name, $where);
		}
	}
