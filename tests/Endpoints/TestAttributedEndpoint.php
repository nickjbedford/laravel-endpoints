<?php
	namespace YetAnother\Tests\Endpoints;
	
	use Illuminate\Http\Request;
	use Symfony\Component\HttpFoundation\Response;
	use YetAnother\Laravel\AttributedEndpoint;
	use YetAnother\Laravel\Attributes\Delete;
	use YetAnother\Laravel\Attributes\Get;
	use YetAnother\Laravel\Attributes\Middleware;
	use YetAnother\Laravel\Attributes\Patch;
	use YetAnother\Laravel\Attributes\Post;
	use YetAnother\Laravel\Attributes\RoutePrefix;
	use YetAnother\Laravel\Attributes\Uri;
	use YetAnother\Tests\TestMiddleware;
	
	#[Uri(TestAttributedEndpoint::URI)]
	#[RoutePrefix(TestAttributedEndpoint::PREFIX)]
	#[Middleware('web')]
	class TestAttributedEndpoint extends AttributedEndpoint
	{
		const string URI = '/test-endpoint';
		const string PREFIX = 'test.endpoint.';
		
		const string GetResponse = 'Hello, world';
		const string PostResponse = "It's posted!";
		const string UpdateResponse = "Patched the hole.";
		const string DeleteResponse = "It's gone :(";
		
		#[Get('/{user?}')]
		#[Middleware('test.middleware')]
		function get(Request $request): Response
		{
			if (TestMiddleware::$urlHandled !== $request->url())
				return $this->error('Middleware did not handle the request correctly.');
			return $this->success($request->user ?? self::GetResponse);
		}
		
		#[Post]
		function post(Request $request): Response
		{
			if (TestMiddleware::$urlHandled === $request->url())
				return $this->error('Middleware handled the request when it shouldn\'t have.');
			return $this->success(self::PostResponse);
		}
		
		#[Post('/other')]
		function postOther(): Response
		{
			return $this->success(self::PostResponse . 'other');
		}
		
		#[Patch]
		function update(): Response
		{
			return $this->success(self::UpdateResponse);
		}
		
		#[Delete]
		function delete(): Response
		{
			return $this->success(self::DeleteResponse);
		}
	}