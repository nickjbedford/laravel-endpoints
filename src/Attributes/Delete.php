<?php
	
	namespace YetAnother\Laravel\Attributes;
	
	use Attribute;
	
	#[Attribute]
	readonly class Delete extends Route
	{
		public function __construct(
			string $uri = '',
			?string $name = null,
			?array $where = null)
		{
			parent::__construct('DELETE', $uri, $name, $where);
		}
	}
