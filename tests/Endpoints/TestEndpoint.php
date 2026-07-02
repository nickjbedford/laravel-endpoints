<?php
	namespace YetAnother\Tests\Endpoints;
	
	use Illuminate\Http\Request;
	use Symfony\Component\HttpFoundation\Response;
	use YetAnother\Laravel\Endpoint;
	
	class TestEndpoint extends Endpoint
	{
		const string URI = '/test-endpoint';
		const string PREFIX = 'test.endpoint.';
		const string GetResponse = 'Hello, world';
		const string PostResponse = "It's posted!";
		const string UpdateResponse = "Patched the hole.";
		const string DeleteResponse = "It's gone :(";
		
		protected string $uri = self::URI;
		protected bool $get = true;
		protected bool $post = true;
		protected bool $update = true;
		protected bool $delete = true;
		protected string $routePrefix = self::PREFIX;
		
		protected ?string $getUri = '/{user?}';
		
		function get(Request $request): Response
		{
			return $this->success($request->user ?? self::GetResponse);
		}
		
		function post(): Response
		{
			return $this->success(self::PostResponse);
		}
		
		function update(): Response
		{
			return $this->success(self::UpdateResponse);
		}
		
		function delete(): Response
		{
			return $this->success(self::DeleteResponse);
		}
	}