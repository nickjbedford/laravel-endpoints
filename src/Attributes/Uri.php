<?php
	
	namespace YetAnother\Laravel\Attributes;
	
	use Attribute;
	
	/**
	 * Attributes middleware to an endpoint class.
	 */
	#[Attribute(Attribute::TARGET_CLASS)]
	readonly class Uri
	{
		public string $uriPrefix;
		
		/**
		 * @param string $uriPrefix
		 */
		public function __construct(string $uriPrefix = '')
		{
			$this->uriPrefix = $uriPrefix;
		}
	}
