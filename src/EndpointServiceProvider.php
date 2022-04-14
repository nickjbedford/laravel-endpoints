<?php
	
	namespace YetAnother\Laravel;
	
	use Exception;
	use Illuminate\Support\ServiceProvider;
	
	class EndpointServiceProvider extends ServiceProvider
	{
		/**
		 * @return void
		 * @throws Exception
		 */
		public function boot()
		{
			collect(config('endpoints', []))
				->each(function(string $class)
				{
					$endpoint = new $class();
					
					if (!($endpoint instanceof Endpoint))
						throw new Exception("$class is not an instance of " . Endpoint::class);
					
					$endpoint->register();
				});
		}
	}
