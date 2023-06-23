<?php
	namespace YetAnother\Tests\Endpoints;
	
	use YetAnother\Tests\TestCase;
	
	class TestAttributeEndpointTestCase extends TestCase
	{
		protected function setUp(): void
		{
			parent::setUp();
		}
		
		protected function setUpApplicationRoutes(): void
		{
			$endpoint = new TestAttributedEndpoint();
			$endpoint->register();
		}
		
		function testTestAttributedEndpointRoutesAreCreated()
		{
			$domainUrl = config('app.url');
			$url = $domainUrl . TestAttributedEndpoint::URI;
			
			self::assertEquals($url, route(TestAttributedEndpoint::PREFIX . 'get'));
			self::assertEquals($url, route(TestAttributedEndpoint::PREFIX . 'post'));
			self::assertEquals($url, route(TestAttributedEndpoint::PREFIX . 'update'));
			self::assertEquals($url, route(TestAttributedEndpoint::PREFIX . 'delete'));
		}
		
		function testTestAttributedEndpointGetReturnsSuccess()
		{
			$url = route(TestAttributedEndpoint::PREFIX . 'get', ['user' => 123]);
			$this->assertEquals(url(TestAttributedEndpoint::URI . "/123"), $url);
			
			$response = $this->get($url)
			                 ->assertOk()
			                 ->getOriginalContent();
			
			self::assertTrue($response['success']);
			self::assertEquals(123, $response['data']);
		}
		
		function testTestAttributedEndpointPostReturnsSuccess()
		{
			$response = $this->post(route(TestAttributedEndpoint::PREFIX . 'post'))
				->assertOk()
				->getOriginalContent();
			
			self::assertTrue($response['success']);
			self::assertEquals(TestAttributedEndpoint::PostResponse, $response['data']);
		}
		
		function testTestAttributedEndpointUpdateReturnsSuccess()
		{
			$response = $this->patch(route(TestAttributedEndpoint::PREFIX . 'update'))
				->assertOk()
				->getOriginalContent();
			
			self::assertTrue($response['success']);
			self::assertEquals(TestAttributedEndpoint::UpdateResponse, $response['data']);
		}
		
		function testTestAttributedEndpointDeleteReturnsSuccess()
		{
			$response = $this->delete(route(TestAttributedEndpoint::PREFIX . 'delete'))
				->assertOk()
				->getOriginalContent();
			
			self::assertTrue($response['success']);
			self::assertEquals(TestAttributedEndpoint::DeleteResponse, $response['data']);
		}
	}
