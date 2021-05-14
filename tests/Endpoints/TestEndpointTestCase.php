<?php
	namespace Endpoints;
	
	use Orchestra\Testbench\TestCase;
	
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
			$response = $this->get(route(TestEndpoint::PREFIX . 'get'))
				->assertOk()
				->getOriginalContent();
			
			self::assertTrue($response['success']);
			self::assertEquals(TestEndpoint::GetResponse, $response['data']);
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