<?php declare(strict_types=1);

namespace KOA2\Service;

use KOA2\Service\Contract\AccessTokenProviderInterface;
use KOA2\Service\Contract\OauthServerProviderInterface;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AccessTokenProvider implements AccessTokenProviderInterface
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
     * @return ResponseInterface
     * @throws OAuthServerException
     */
    public function getAccessToken(): ResponseInterface
    {
        $oauthServer = $this->oauthServerProvider->getServer();

        return $oauthServer->respondToAccessTokenRequest($this->request, $this->response);
    }
}
