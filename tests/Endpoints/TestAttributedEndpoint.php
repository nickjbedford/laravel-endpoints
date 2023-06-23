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
	
	#[Uri(TestAttributedEndpoint::URI)]
	#[RoutePrefix(TestAttributedEndpoint::PREFIX)]
	#[Middleware('web')]
	class TestAttributedEndpoint extends AttributedEndpoint
	{
		const URI = '/test-endpoint';
		const PREFIX = 'test.endpoint.';
		
		const GetResponse = 'Hello, world';
		const PostResponse = "It's posted!";
		const UpdateResponse = "Patched the hole.";
		const DeleteResponse = "It's gone :(";
		
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
