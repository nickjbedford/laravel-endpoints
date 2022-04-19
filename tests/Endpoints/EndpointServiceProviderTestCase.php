<?php
	namespace YetAnother\Tests\Endpoints;
	
	use Illuminate\Support\Facades\Artisan;
	use Symfony\Component\Console\Output\BufferedOutput;
	use YetAnother\Laravel\EndpointServiceProvider;
	use YetAnother\Tests\TestCase;
	
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
			
			Artisan::call("route:list", [], $output = new BufferedOutput());
			$output = $output->fetch();
			
			self::assertEquals($url, route(TestEndpoint::PREFIX . 'get'));
			self::assertEquals($url, route(TestEndpoint::PREFIX . 'post'));
			self::assertEquals($url, route(TestEndpoint::PREFIX . 'update'));
			self::assertEquals($url, route(TestEndpoint::PREFIX . 'delete'));
		}
	}
