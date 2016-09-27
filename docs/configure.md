# Configure Laravel PHP Framework for Oauth2 

## composer.json

~~~
"require": {
        "php": ">=5.5.9",
        "laravel/framework": "5.2.*",
        "dingo/api": "1.0.*dev",
        "lucadegasperi/oauth2-server-laravel": "5.1.*"
    }
~~~

## Add OAuthServiceProvider.php <php artisan make:provider OAuthServiceProvider>

```php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Dingo\Api\Auth\Auth;
use Dingo\Api\Auth\Provider\OAuth2;
use App\User;

class OAuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app[Auth::class]->extend('oauth', function ($app) {
            $provider = new OAuth2($app['oauth2-server.authorizer']->getChecker());

            $provider->setUserResolver(function ($id) {
                // Logic to return a user by their ID.
                $user = User::find($id);
                return $user;
            });

            $provider->setClientResolver(function ($id) {
                // Logic to return a client by their ID.
            });

            return $provider;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
```

##config/app.php
```php
	'providers' => [
		.........
		/**
    	 * Customized Service Providers...
    	 */
    	Dingo\Api\Provider\LaravelServiceProvider::class,
    		
    	LucaDegasperi\OAuth2Server\Storage\FluentStorageServiceProvider::class,
    	LucaDegasperi\OAuth2Server\OAuth2ServerServiceProvider::class,
    		
    	App\Providers\OAuthServiceProvider::class,
	]
	
	'aliases' => [
		............
		'Authorizer' => LucaDegasperi\OAuth2Server\Facades\Authorizer::class,
	]
```

## Kernel.php

```php
	protected $middleware = [
        ........
   		\LucaDegasperi\OAuth2Server\Middleware\OAuthExceptionHandlerMiddleware::class,
    ];
    
   'web' => [
   		............
        //\App\Http\Middleware\VerifyCsrfToken::class,
    ]
    protected $routeMiddleware = [
        ............
   		'csrf' => \App\Http\Middleware\VerifyCsrfToken::class,

   		'oauth' => \LucaDegasperi\OAuth2Server\Middleware\OAuthMiddleware::class,
   		'oauth-user' => \LucaDegasperi\OAuth2Server\Middleware\OAuthUserOwnerMiddleware::class,
   		'oauth-client' => \LucaDegasperi\OAuth2Server\Middleware\OAuthClientOwnerMiddleware::class,
    	'check-authorization-params' => \LucaDegasperi\OAuth2Server\Middleware\CheckAuthCodeRequestMiddleware::class,
    ];
```

