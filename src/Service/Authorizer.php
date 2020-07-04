<?php declare(strict_types=1);

namespace KOA2\Service;

use KOA2\Service\Contract\AccessTokenProviderInterface;
use KOA2\Service\Contract\AuthorizerInterface;
use KOA2\Service\Contract\OauthServerProviderInterface;
use KOA2\Service\Contract\VerifierCodeProviderInterface;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\RequestTypes\AuthorizationRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Authorizer implements AuthorizerInterface
{
    /**
     * @var OauthServerProviderInterface
     */
    private $oauthServerProvider;

    /**
     * @var ServerRequestInterface
     */
    private $request;

    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @var AuthorizationServer
     */
    private $oauthServer;

    /**
     * Authorizer constructor.
     *
     * @param OauthServerProviderInterface $oauthServerProvider
     * @param ServerRequestInterface       $request
     * @param ResponseInterface            $response
     */
    public function __construct(
        OauthServerProviderInterface $oauthServerProvider,
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $this->oauthServerProvider = $oauthServerProvider;
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return AuthorizationRequest
     * @throws OAuthServerException
     */
    public function getAuthRequest(): AuthorizationRequest
    {
        $this->oauthServer = $this->oauthServerProvider->getServer();

        return $this->oauthServer->validateAuthorizationRequest($this->request);
    }

    /**
     * @param AuthorizationRequest $authRequest
     *
     * @return ResponseInterface
     */
    public function complete(AuthorizationRequest $authRequest): ResponseInterface
    {
        return $this->oauthServer->completeAuthorizationRequest($authRequest, $this->response);
    }
}
