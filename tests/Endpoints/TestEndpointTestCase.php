<?php
	namespace YetAnother\Tests\Endpoints;
	
	use YetAnother\Tests\TestCase;
	
	class TestEndpointTestCase extends TestCase
	{
		protected function setUpApplicationRoutes(): void
		{
			$endpoint = new TestEndpoint();
			$endpoint->register();
		}
		
		function testTestEndpointRoutesAreCreated()
		{
			$domainUrl = config('app.url');
			$url = $domainUrl . TestEndpoint::URI;
			
			self::assertEquals($url, route(TestEndpoint::PREFIX . 'get'));
			self::assertEquals($url, route(TestEndpoint::PREFIX . 'post'));
			self::assertEquals($url, route(TestEndpoint::PREFIX . 'update'));
			self::assertEquals($url, route(TestEndpoint::PREFIX . 'delete'));
		}
		
		function testTestEndpointGetReturnsSuccess()
		{
			$url = route(TestEndpoint::PREFIX . 'get', ['user' => 123]);
			$this->assertEquals(url(TestEndpoint::URI . "/123"), $url);
			
			$response = $this->get($url)
			                 ->assertOk()
			                 ->getOriginalContent();
			
			self::assertTrue($response['success']);
			self::assertEquals(123, $response['data']);
		}
		
		function testTestEndpointPostReturnsSuccess()
		{
			$response = $this->post(route(TestEndpoint::PREFIX . 'post'))
				->assertOk()
				->getOriginalContent();
			
			self::assertTrue($response['success']);
			self::assertEquals(TestEndpoint::PostResponse, $response['data']);
		}
		
		function testTestEndpointUpdateReturnsSuccess()
		{
			$response = $this->patch(route(TestEndpoint::PREFIX . 'update'))
				->assertOk()
				->getOriginalContent();
			
			self::assertTrue($response['success']);
			self::assertEquals(TestEndpoint::UpdateResponse, $response['data']);
		}
		
		function testTestEndpointDeleteReturnsSuccess()
		{
			$response = $this->delete(route(TestEndpoint::PREFIX . 'delete'))
				->assertOk()
				->getOriginalContent();
			
			self::assertTrue($response['success']);
			self::assertEquals(TestEndpoint::DeleteResponse, $response['data']);
		}
	}
