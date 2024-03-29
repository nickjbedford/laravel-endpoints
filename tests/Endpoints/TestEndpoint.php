<?php
	namespace YetAnother\Tests\Endpoints;
	
	use Illuminate\Http\Request;
	use Symfony\Component\HttpFoundation\Response;
	use YetAnother\Laravel\Endpoint;
	
	class TestEndpoint extends Endpoint
	{
		const URI = '/test-endpoint';
		const PREFIX = 'test.endpoint.';
		const GetResponse = 'Hello, world';
		const PostResponse = "It's posted!";
		const UpdateResponse = "Patched the hole.";
		const DeleteResponse = "It's gone :(";
		
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
		
		function post(Request $request): Response
		{
			return $this->success(self::PostResponse);
		}
		
		function update(Request $request): Response
		{
			return $this->success(self::UpdateResponse);
		}
		
		function delete(Request $request): Response
		{
			return $this->success(self::DeleteResponse);
		}
	}
