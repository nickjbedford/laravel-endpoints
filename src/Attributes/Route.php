<?php
	namespace YetAnother\Laravel\Attributes;
	
	use Attribute;
	use YetAnother\Laravel\Method;
	
	/**
	 * Attributes a route to an endpoint class method.
	 */
	#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
	readonly class Route
	{
		/** @var string[] $methods */
		public array $methods;
		
		/**
		 * @param Method[] $methods
		 * @param string $uri
		 * @param string|null $name
		 * @param array|null $where
		 */
		public function __construct(
			array $methods,
			public string $uri = '',
			public ?string $name = null,
			public ?array $where = null,
		)
		{
			$this->methods = array_map(fn(Method $method) => $method->value, $methods);
		}
	}
