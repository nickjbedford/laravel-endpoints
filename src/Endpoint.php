<?php
	/**
	 * @noinspection PhpReturnDocTypeMismatchInspection
	 * @noinspection PhpUnusedParameterInspection
	 * @noinspection PhpUnused
	 */
	
	namespace YetAnother\Laravel;
	
	use Illuminate\Routing\Route;
	use Illuminate\Routing\Router;
	
	/**
	 * Represents an endpoint controller.
	 */
	abstract class Endpoint
	{
		use RespondsWithJsonShortcuts,
			CreatesRoutes;
		
		/** @var string $uri Set this property to the URI of the API endpoint. */
		protected string $uri = '';
		
		/** @var string[]|null $middleware Set this property to add middleware to each route in the endpoint. */
		protected ?array $middleware = null;
		
		protected bool $get = false;
		protected bool $post = false;
		protected bool $update = false;
		protected bool $delete = false;
		
		/** @var string|null Specifies a custom URI for the GET method. */
		protected ?string $getUri = null;
		
		/** @var string|null Specifies a custom URI for the POST method. */
		protected ?string $postUri = null;
		
		/** @var string|null Specifies a custom URI for the PATCH method. */
		protected ?string $updateUri = null;
		
		/** @var string|null Specifies a custom URI for the DELETE method. */
		protected ?string $deleteUri = null;
		
		/**
		 * Registers the endpoint routes. This method can be called within a Route::group() call and
		 * does not define any wrapping group itself.
		 * @param Router|null $router
		 */
		public function register(?Router $router = null)
		{
			$router ??= app('router');
			$routes = [];
			
			if ($this->get)
				$routes[] = $this->createNamedRoute($router, ['get', 'head'], 'get', $this->getUri);
			
			if ($this->post)
				$routes[] = $this->createNamedRoute($router, 'post', 'post', $this->postUri);
			
			if ($this->update)
				$routes[] = $this->createNamedRoute($router, 'patch', 'update', $this->updateUri);
			
			if ($this->delete)
				$routes[] = $this->createNamedRoute($router, 'delete', 'delete', $this->deleteUri);
			
			/** @var \YetAnother\Laravel\Attributes\Route $route */
			foreach($routes as $route)
			{
				if ($this->middleware)
					$route->middleware($this->middleware);
			}
			
			$this->registerCustomRoutes($router);
		}
		
		/**
		 * Allows the endpoint to register any additional custom routes under the same group settings.
		 * Use the getClosure(), getRouteName() and createdNamedRoute() helper methods to bind your endpoint's routes.
		 * This method is not called within a group for the endpoint and as such does include bindings to the
		 * endpoint middleware and URI/route name prefixes.
		 * @param Router|null $router
		 * @return void
		 */
		protected function registerCustomRoutes(?Router $router)
		{
		}
	}
