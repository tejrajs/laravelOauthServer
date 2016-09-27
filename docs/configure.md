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

## app\Verifier\PasswordGrantVerifier.php

```php
namespace App\Verifier;


use Illuminate\Support\Facades\Auth;

class PasswordGrantVerifier
{
	public function verify($username, $password)
	{
		$credentials = [
				'email'    => $username,
				'password' => $password,
		];

		if (Auth::once($credentials)) {
			return Auth::user()->id;
		}

		return false;
	}
}
```

## config/oauth2.php

```php
	'grant_types' => [
    	'password' => [
    		'class' => 'League\OAuth2\Server\Grant\PasswordGrant',
    		// the code to run in order to verify the user's identity
    		'callback' => 'App\Verifier\PasswordGrantVerifier@verify',
    		'access_token_ttl' => 604800,
    	],
    	'refresh_token' => [
    		'class' => '\League\OAuth2\Server\Grant\RefreshTokenGrant',
    		'access_token_ttl' => 2592000,
    		'refresh_token_ttl' => 2592000
    	]
    ],
```

## app/Http/routes.php

```php
/**
 * Api
 */
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
	$api->post('oauth/access_token', function() {
		return Authorizer::issueAccessToken();
	});
});
```
## run in MySql 
~~~
INSERT INTO `oauth_clients` (`id`, `secret`, `name`, `created_at`, `updated_at`) VALUES
('client_id.dddd8f3833b', 'secret@cf6ggatd59c455tc0te8tatt5b', ‘My website’, ‘2016–05–12 11:00:00’, ‘0000–00–00 00:00:00’);
~~~
