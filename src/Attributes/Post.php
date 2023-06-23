<?php
	
	namespace YetAnother\Laravel\Attributes;
	
	use Attribute;
	use YetAnother\Laravel\Method;
	
	#[Attribute]
	readonly class Post extends Route
	{
		public function __construct(
			string $uri = '',
			?string $name = null,
			?array $where = null)
		{
			parent::__construct([Method::Post], $uri, $name, $where);
		}
	}
