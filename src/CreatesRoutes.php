<?php
	
	namespace YetAnother\Laravel;
	
	use Closure;
	use Illuminate\Routing\Route;
	use Illuminate\Routing\Router;
	
	trait CreatesRoutes
	{
		/** @var string $routePrefix Set this property to the route prefix for all routes on this endpoint. */
		protected string $routePrefix = '';
		
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
		 * @return \YetAnother\Laravel\Attributes\Route
		 */
		protected function createNamedRoute(Router $router, $methods, string $name, ?string $uri = null): Route
		{
			if (is_array($methods))
				$methods = array_map(fn($method) => strtoupper($method), $methods);
			else
				$methods = strtoupper($methods);
			
			return $router->addRoute($methods, $this->uri . ($uri ?? ''), $this->getClosure($name))->name($this->getRouteName($name));
		}
	}
