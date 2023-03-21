<?php
	/**
	 * @noinspection PhpReturnDocTypeMismatchInspection
	 * @noinspection PhpUnusedParameterInspection
	 * @noinspection PhpUnused
	 */
	
	namespace YetAnother\Laravel;
	
	use Closure;
	use Illuminate\Contracts\Support\Responsable;
	use Illuminate\Http\Request;
	use Illuminate\Routing\Route;
	use Illuminate\Routing\Router;
	use Symfony\Component\HttpFoundation\Response;
	use Throwable;
	use YetAnother\Laravel\Traits\RespondsWithJson;
	
	/**
	 * Represents an endpoint controller.
	 */
	abstract class Endpoint
	{
		use RespondsWithJson;
		
		/** @var string $uri Set this property to the URI of the API endpoint. */
		protected string $uri = '';
		
		/** @var string $routePrefix Set this property to the route prefix for all routes on this endpoint. */
		protected string $routePrefix = '';
		
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
			
			/** @var Route $route */
			foreach($routes as $route)
			{
				if ($this->middleware)
					$route->middleware($this->middleware);
			}
			
			$this->registerCustomRoutes($router);
		}
		
		/**
		 * Creates a closure for the instance method on this endpoint.
		 * @param string $method
		 * @return Closure
		 */
		protected function getClosure(string $method): Closure
		{
			return Closure::fromCallable([$this, $method]);
		}
		
		/**
		 * Creates a route name based on the route prefix and method name.
		 * @param string $method
		 * @return string
		 */
		protected function getRouteName(string $method): string
		{
			return $this->routePrefix . $method;
		}
		
		/**
		 * Creates a named route using the same method name as the route name.
		 * @param Router $router The router used to register the route.
		 * @param string|string[] $methods
		 * @param string $name The name of the method and the route name.
		 * @param string|null $uri The URI for the route, or null to use the endpoint's default URI.
		 * @return Route
		 */
		protected function createNamedRoute(Router $router, $methods, string $name, ?string $uri = null): Route
		{
			if (is_array($methods))
				$methods = array_map(fn($method) => strtoupper($method), $methods);
			else
				$methods = strtoupper($methods);
			
			return $router->addRoute($methods, $this->uri . ($uri ?? ''), $this->getClosure($name))->name($this->getRouteName($name));
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

		/**
		 * Returns a JSON response indicating success.
		 * @param mixed|null $data An optional data payload for the client.
		 * @return Response
		 */
		protected function success($data = null): Response
		{
			return response()->json($this->jsonSuccess($data)->toArray());
		}

		/**
		 * Returns a JSON response indicating failure with an optional error code and data payload.
		 * @param string $errorMessage The error message to display to the user.
		 * @param string|null $errorCode An optional error code for the client to use in handling the error.
		 * @param array $errorData An optional data payload with further information
		 * @return Response
		 */
		protected function error(string $errorMessage, ?string $errorCode = null, array $errorData = []): Response
		{
			return response()->json($this->jsonFailure($errorMessage, $errorCode, $errorData)->toArray());
		}
		
		/**
		 * Returns a JSON response indication failure from an exception, with optional debugging data
		 * about the exception included in the error data payload.
		 * @param Throwable $exception The exception that was thrown.
		 * @param bool|null $includeDebugData Whether or not to include the debugging information about the
		 * exception in the error payload. This will default to the JsonResponse::$debugMode value.
		 * @return Response
		 */
		protected function exception(Throwable $exception, ?bool $includeDebugData = null): Response
		{
			report($exception);
			return response()->json($this->jsonException($exception, $includeDebugData)->toArray());
		}
	}
