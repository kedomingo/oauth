<?php declare(strict_types=1);

require 'vendor/autoload.php';

use GuzzleHttp\Psr7\Response;
use KOA2\Model\User;
use KOA2\Service\Contract\AccessTokenProviderInterface;
use KOA2\Service\Contract\AuthorizerInterface;
use League\OAuth2\Server\Exception\OAuthServerException;

foreach (explode("\n", file_get_contents('.env')) as $line) {
    if (trim($line) === '') {
        continue;
    }
    putenv($line);
}

$containerBuilder = new \DI\ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/src/DI/Main_Config.php');
$container = $containerBuilder->build();
/**
 * @var AuthorizerInterface $authorizer
 */
$authorizer = $container->get(AuthorizerInterface::class);

$authRequest = $authorizer->getAuthRequest();

// After login is verified...
$authRequest->setUser(new User(123));
$authRequest->setAuthorizationApproved(true);
$response = $authorizer->complete($authRequest);

print_r($response->getHeader('Location'));

// Post to this with the following data
// localhost:8080/access_token.php
// grant_type=client_credentials
// client_id=1
// client_secret=qfrRVKNrN0iQNrFTymZD6CUgdf9GJCxD4pRHXCvp
