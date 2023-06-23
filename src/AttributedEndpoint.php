<?php
	/**
	 * @noinspection PhpReturnDocTypeMismatchInspection
	 * @noinspection PhpUnusedParameterInspection
	 * @noinspection PhpUnused
	 */
	
	namespace YetAnother\Laravel;
	
	use Illuminate\Routing\Router;
	use ReflectionClass;
	use ReflectionMethod;
	use YetAnother\Laravel\Attributes\Delete;
	use YetAnother\Laravel\Attributes\Get;
	use YetAnother\Laravel\Attributes\Middleware;
	use YetAnother\Laravel\Attributes\Patch;
	use YetAnother\Laravel\Attributes\Post;
	use YetAnother\Laravel\Attributes\Put;
	use YetAnother\Laravel\Attributes\RoutePrefix;
	use YetAnother\Laravel\Attributes\Uri;
	
	/**
	 * Represents an endpoint controller that uses PHP attributes to specify route information.
	 */
	abstract class AttributedEndpoint
	{
		use RespondsWithJsonShortcuts,
			CreatesRoutes;
		
		const RouteAttributes = [
			Get::class,
			Post::class,
			Put::class,
			Patch::class,
			Delete::class
		];
		
		/**
		 * Registers the endpoint routes. This method can be called within a Route::group() call and
		 * does not define any wrapping group itself.
		 * @param Router|null $router
		 */
		public function register(?Router $router = null): void
		{
			$reflection = new ReflectionClass($this);
			
			/** @var string[] $middleware */
			$middleware = $reflection->getAttributes(Middleware::class)[0]?->newInstance()->middleware ?? [];
			$routePrefix = $reflection->getAttributes(RoutePrefix::class)[0]?->newInstance()->prefix ?? '';
			$uriPrefix = $reflection->getAttributes(Uri::class)[0]?->newInstance()->uriPrefix ?? '';
			
			$router ??= app('router');
			
			foreach($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method)
			{
				foreach($method->getAttributes() as $attribute)
				{
					if (in_array($attribute->getName(), self::RouteAttributes) &&
					    $instance = $attribute->newInstance())
					{
						$action = $this->getClosure($method->getName());
						$name = $routePrefix . ($instance->name ?? $method->getName());
						$uri = $uriPrefix . $instance->uri;
						
						$route = $router->addRoute($instance->methods, $uri, $action)
						                ->name($this->getRouteName($name));
	
						if (!empty($middleware))
							$route->middleware($middleware);
					}
				}
			}
			
			$this->registerCustomRoutes($router, $middleware, $routePrefix);
		}
		
		/**
		 * Allows the endpoint to register any additional custom routes under the same group settings.
		 * Use the getClosure(), getRouteName() and createdNamedRoute() helper methods to bind your endpoint's routes.
		 * This method is not called within a group for the endpoint and as such does include bindings to the
		 * endpoint middleware and URI/route name prefixes.
		 * @param Router|null $router
		 * @param array $middleware
		 * @param string $routePrefix
		 * @return void
		 */
		protected function registerCustomRoutes(?Router $router, array $middleware, string $routePrefix = '')
		{
		}
	}
