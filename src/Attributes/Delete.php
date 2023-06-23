<?php
	
	namespace YetAnother\Laravel\Attributes;
	
	use Attribute;
	use YetAnother\Laravel\Method;
	
	/**
	 * Attributes a DELETE route to an endpoint class method.
	 */
	#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
	readonly class Delete extends Route
	{
		public function __construct(
			string $uri = '',
			?string $name = null,
			?array $where = null)
		{
			parent::__construct([Method::Delete], $uri, $name, $where);
		}
	}
