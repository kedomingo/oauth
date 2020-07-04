<?php declare(strict_types=1);

require 'vendor/autoload.php';

use DI\Container;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use KOA2\Http\Request;

use KOA2\Model\Client as ClientModel;
use KOA2\PDO\ConnectionInterface;
use KOA2\Persistence\DB\AuthCode;
use KOA2\Model\AuthCode as AuthCodeModel;
use KOA2\Model\Scope;
use KOA2\Repository\Contract\AccessTokenRepositoryInterface;
use KOA2\Repository\Contract\ClientRepositoryInterface;
use KOA2\Repository\Contract\ScopeRepositoryInterface;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\ClientCredentialsGrant;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Bootstrap
{
    /**
     * @var ConnectionInterface
     */
    private $dbconnection;

    /**
     * @var AuthorizationServer
     */
    private $server;

    public function __construct(
        ConnectionInterface $dbconnection,
        AuthCode $clientPersistence,
        ClientRepositoryInterface $clientRepository,
        ScopeRepositoryInterface $scopeRepository,
        AccessTokenRepositoryInterface $accessTokenRepository

    ) {
        $privateKey = getenv('OAUTH_PRIVATE_KEY');
        $encryptionKey = getenv('APP_KEY');

        // Setup the authorization server
        $this->server = new AuthorizationServer(
            $clientRepository,
            $accessTokenRepository,
            $scopeRepository,
            $privateKey,
            $encryptionKey
        );

        // Enable the client credentials grant on the server
        $this->server->enableGrantType(
            new ClientCredentialsGrant(),
            new DateInterval('PT1H') // access tokens will expire after 1 hour
        );
    }

    public function getToken(ServerRequestInterface $request, ResponseInterface $response)
    {
        $result = $this->server->respondToAccessTokenRequest($request, $response);
        echo $result->getBody();
    }
}

foreach (explode("\n", file_get_contents('.env')) as $line) {
    if (trim($line) === '') {
        continue;
    }
    putenv($line);
}

// Try with
// localhost:8080/authorize.php?grant_type=client_credentials&client_id=1&client_secret=qfrRVKNrN0iQNrFTymZD6CUgdf9GJCxD4pRHXCvp

$request = ServerRequest::fromGlobals();
$response = new Response();

$containerBuilder = new \DI\ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/src/DI/Main_Config.php');
$container = $containerBuilder->build();
$bootstrap = $container->get(Bootstrap::class);
$bootstrap->getToken($request, $response);