# KOA2 

OAuth 2.0 Server implementation based on thephpleague/oauth2-server.

This is intended to be a framework-less package that can be plugged in to
any framework with minimal configuration.

## Installation

Generate a private key 
```
$ openssl genrsa -out private.key 2048
$ chmod 600 private.key
```

Extract public key from private key
```
$ openssl rsa -in private.key -pubout -out public.key
```

For more information check out https://oauth2.thephpleague.com/installation/

### Lumen

You might need the following composer packages when using this in Lumen

```bash
$ composer require nyholm/psr7 symfony/psr-http-message-bridge
```

Register the service in `bootstrap/app.php`

```php
$app->register(OauthServiceProvider::class);
```

Define the environment variables `OAUTH_PRIVATE_KEY` and `OAUTH_PUBLIC_KEY` pointing to the absolute location of 
the private and public key.

```
OAUTH_PRIVATE_KEY=/your/path/to/private.key
OAUTH_PUBLIC_KEY=/your/path/to/public.key
```

Create a controller for the token provider

```php
<?php

namespace App\Http\Controllers;

use KOA2\Service\Contract\AccessTokenProviderInterface;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ResponseInterface;

class OauthController extends Controller
{
    /**
     * @param AccessTokenProviderInterface $tokenProvider
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function getToken(AccessTokenProviderInterface $tokenProvider, ResponseInterface $response)
    {
        try {
            return $tokenProvider->getAccessToken();
        } catch (OAuthServerException $exception) {
            return $exception->generateHttpResponse($response);
        }
    }

}
```
