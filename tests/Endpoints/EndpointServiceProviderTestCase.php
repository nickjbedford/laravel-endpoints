<?php
	namespace Endpoints;
	
	use Orchestra\Testbench\TestCase;
	use YetAnother\Laravel\EndpointServiceProvider;
	
	class EndpointServiceProviderTestCase extends TestCase
	{
		protected function getEnvironmentSetUp($app)
		{
			$app['config']->set('endpoints', [
				TestEndpoint::class
			]);
		}
		
		protected function getPackageProviders($app): array
		{
			return [
				EndpointServiceProvider::class
			];
		}
		
		function testTestEndpointRoutesAreCreatedByServiceProvider()
		{
			$domainUrl = config('app.url');
			$url = $domainUrl . TestEndpoint::URI;
			
			self::assertEquals($url, route(TestEndpoint::PREFIX . 'get'));
			self::assertEquals($url, route(TestEndpoint::PREFIX . 'post'));
			self::assertEquals($url, route(TestEndpoint::PREFIX . 'update'));
			self::assertEquals($url, route(TestEndpoint::PREFIX . 'delete'));
		}
	}
