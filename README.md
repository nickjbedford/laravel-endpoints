# Laravel Endpoints

The Laravel Endpoints framework provides an easy way to implement API endpoints
in separate classes that are then registered automatically based on the properties
defined in each endpoint subclass.

To create an endpoint, extend the `YetAnother\Laravel\Endpoint` abstract class,
defining whether to include the GET, POST, UPDATE or DELETE route methods. You
must also specify the URI of the route as well as the route prefix for all
automatically registered routes.

The `Endpoint` base class provides convenient methods to return JSON success,
failure and exception response in a standard structure according to the
[nickjbedford/json-response-laravel](https://github.com/nickjbedford/json-response-laravel) package.

```php
class UsersEndpoint extends YetAnother\Laravel\Endpoint
{
    // Specify the URI of the endpoint.
    protected string $uri = '/users';
    
    // Specify the route prefix for the endpoint methods.
    // The suffixes are get, post, update and delete.
    protected string $routePrefix = 'users.';
    
    // Register the following methods when set to true.
    protected bool $get = true;
    protected bool $post = true;
    protected bool $update = true;
    protected bool $delete = true;
    
    /**
     * Override the GET method. 
     * @param Request $request
     * @return Response
     */
    function get(Request $request): Response
    {
        $users = /* fetch user(s) */;
        return $this->success($users);
    }
    
    /**
     * Override the POST method. 
     * @param Request $request
     * @return Response
     */
    function post(Request $request): Response
    {
        $user = /* create new user */;
        return $this->success($user);
    }
    
    /**
     * Override the PATCH method. 
     * @param Request $request
     * @return Response
     */
    function update(Request $request): Response
    {
        $user = /** fetch and update user */
        return $this->success(self::UpdateResponse);
    }
    
    /**
     * Override the DELETE method. 
     * @param Request $request
     * @return Response
     */
    function delete(Request $request): Response
    {
        /** fetch and delete user */
        return $this->success(self::DeleteResponse);
    }
}
```

## Registering Endpoints

### Manual Registration

The `Endpoint` base class includes the `register()` method for automatically
registering the endpoint's routes. Simply call `$endpoint->register()`
on all of your endpoint subclass instances to register them.

### Service Provider Registration

This package also includes the `YetAnother\Laravel\EndpointServiceProvider`
service provider class that can be used alongside a `config/endpoints.php`
configuration file.

#### [config/app.php]

Add the `YetAnother\Laravel\EndpointServiceProvider::class` entry to the array of `'providers'` in the `config/app.php` configuration file.

```php
    // ...

    'providers' => [
        // ...
        
        YetAnother\Laravel\EndpointServiceProvider::class
    ],

    // ...
```

### [config/endpoints.php]

Create a PHP file in the config directory called endpoints.php and have
it return an array of endpoint class names from your codebase.

```php
    return [
        MyEndpoint::class,
        MyOtherEndpoint::class
    ];
```
