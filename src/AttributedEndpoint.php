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
		
		const RouteAttributesClasses = [
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
		public static function register(?Router $router = null): void
		{
			$reflection = new ReflectionClass(static::class);
			
			/** @var string[] $middleware */
			$attributes = $reflection->getAttributes();
			$group = [];
			
			foreach($attributes as $attribute)
			{
				switch($attribute->getName())
				{
					case Middleware::class:
						$group['middleware'] = $attribute->newInstance()->middleware;
						break;
						
					case RoutePrefix::class:
						$group['as'] = $attribute->newInstance()->routePrefix;
						break;
						
					case Uri::class:
						$group['prefix'] = $attribute->newInstance()->uriPrefix;
						break;
				}
			}
			
			$router ??= app('router');
			$router->group($group, function() use($reflection, $router)
			{
				$className = static::class . '@';
				
				foreach($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method)
				{
					foreach($method->getAttributes() as $attribute)
					{
						if (in_array($attribute->getName(), self::RouteAttributesClasses) &&
						    $instance = $attribute->newInstance())
						{
							$router->addRoute($instance->methods, $instance->uri, $className . $method->getName())
							       ->name($instance->name ?? $method->getName());
						}
					}
				}
			});
		}
	}
