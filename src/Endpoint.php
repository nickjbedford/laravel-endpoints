<?php
	/**
	 * @noinspection PhpReturnDocTypeMismatchInspection
	 * @noinspection PhpUnusedParameterInspection
	 * @noinspection PhpUnused
	 */
	
	namespace YetAnother\Laravel;
	
	use Closure;
	use Exception;
	use Illuminate\Contracts\Support\Responsable;
	use Illuminate\Http\Request;
	use Illuminate\Routing\Route;
	use Illuminate\Routing\Router;
	use Symfony\Component\HttpFoundation\Response;
	use Throwable;
	use YetAnother\Laravel\Traits\RespondsWithJson;
	
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
				$routes[] = $router->get($this->getUri ?: $this->uri, Closure::fromCallable([$this, 'get']))->name("{$this->routePrefix}get");
			
			if ($this->post)
				$routes[] = $router->post($this->postUri ?: $this->uri, Closure::fromCallable([$this, 'post']))->name("{$this->routePrefix}post");
			
			if ($this->update)
				$routes[] = $router->patch($this->updateUri ?: $this->uri, Closure::fromCallable([$this, 'update']))->name("{$this->routePrefix}update");
			
			if ($this->delete)
				$routes[] = $router->delete($this->deleteUri ?: $this->uri, Closure::fromCallable([$this, 'delete']))->name("{$this->routePrefix}delete");
			
			/** @var Route $route */
			foreach($routes as $route)
			{
				if ($this->middleware)
					$route->middleware($this->middleware);
			}
		}
		
		/**
		 * Handles a GET/HEAD request and returns a response.
		 * @param Request $request
		 * @return Response|Responsable
		 * @throws Throwable
		 */
		public function get(Request $request)
		{
			throw new Exception('Endpoint GET handler is not implemented.');
		}
		
		/**
		 * Handles a POST request and returns a response.
		 * @param Request $request
		 * @return Response|Responsable
		 * @throws Throwable
		 */
		public function post(Request $request)
		{
			throw new Exception('Endpoint POST handler is not implemented.');
		}
		
		/**
		 * Handles a PATCH request and returns a response.
		 * @param Request $request
		 * @return Response|Responsable
		 * @throws Throwable
		 */
		public function update(Request $request)
		{
			throw new Exception('Endpoint PATCH handler is not implemented.');
		}
		
		/**
		 * Handles a DELETE request and returns a response.
		 * @param Request $request
		 * @return Response|Responsable
		 * @throws Throwable
		 */
		public function delete(Request $request)
		{
			throw new Exception('Endpoint DELETE handler is not implemented.');
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
