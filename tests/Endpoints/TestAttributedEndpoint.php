<?php
	namespace YetAnother\Tests\Endpoints;
	
	use Illuminate\Http\Request;
	use Symfony\Component\HttpFoundation\Response;
	use YetAnother\Laravel\AttributedEndpoint;
	use YetAnother\Laravel\Attributes\Delete;
	use YetAnother\Laravel\Attributes\Get;
	use YetAnother\Laravel\Attributes\Guard;
	use YetAnother\Laravel\Attributes\Middleware;
	use YetAnother\Laravel\Attributes\Patch;
	use YetAnother\Laravel\Attributes\Post;
	use YetAnother\Laravel\Attributes\RoutePrefix;
	
	#[RoutePrefix(TestAttributedEndpoint::PREFIX)]
	#[Middleware('web')]
	#[Guard('admin')]
	class TestAttributedEndpoint extends AttributedEndpoint
	{
		const URI = '/test-endpoint';
		const PREFIX = 'test.endpoint.';
		
		const GetResponse = 'Hello, world';
		const PostResponse = "It's posted!";
		const UpdateResponse = "Patched the hole.";
		const DeleteResponse = "It's gone :(";
		
		protected string $uri = self::URI;
		
		protected ?string $getUri = '/{user?}';
		
		#[Get('/{user?}')]
		function get(Request $request): Response
		{
			return $this->success($request->user ?? self::GetResponse);
		}
		
		#[Post]
		function post(): Response
		{
			return $this->success(self::PostResponse);
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
