<?php
	
	namespace YetAnother\Tests;
	
	use Closure;
	use Illuminate\Http\Request;
	
	class TestMiddleware
	{
		public static ?string $urlHandled = null;
		
		public function handle(Request $request, Closure $next): mixed
		{
			self::$urlHandled = $request->url();
			return $next($request);
		}
	}