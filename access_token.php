<?php declare(strict_types=1);

require 'vendor/autoload.php';

use GuzzleHttp\Psr7\Response;
use KOA2\Service\Contract\AccessTokenProviderInterface;
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
 * @var AccessTokenProviderInterface $authorizer
 */
$authorizer = $container->get(AccessTokenProviderInterface::class);

try {
    $response = $authorizer->getAccessToken();
    echo $response->getBody();
} catch (OAuthServerException $exception) {
    echo $exception->generateHttpResponse(new Response())->getBody();
}

// Post to this with the following data
// localhost:8080/access_token.php
// grant_type=client_credentials
// client_id=1
// client_secret=qfrRVKNrN0iQNrFTymZD6CUgdf9GJCxD4pRHXCvp
