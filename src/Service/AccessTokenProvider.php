<?php declare(strict_types=1);

namespace KOA2\Service;

use KOA2\Factory\AccessTokenFactory;
use KOA2\Model\AccessToken;
use KOA2\Service\Contract\AccessTokenProviderInterface;
use KOA2\Service\Contract\OauthServerProviderInterface;
use KOA2\Repository\Contract\AccessTokenRepositoryInterface;
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
     * @var AccessTokenRepositoryInterface
     */
    private $accessTokenRepository;

    /**
     * @var AccessTokenFactory
     */
    private $accessTokenFactory;

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
     * @param OauthServerProviderInterface   $oauthServerProvider
     * @param AccessTokenRepositoryInterface $accessTokenRepository
     * @param AccessTokenFactory             $accessTokenFactory
     * @param ServerRequestInterface         $request
     * @param ResponseInterface              $response
     */
    public function __construct(
        OauthServerProviderInterface $oauthServerProvider,
        AccessTokenRepositoryInterface $accessTokenRepository,
        AccessTokenFactory $accessTokenFactory,
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $this->oauthServerProvider = $oauthServerProvider;
        $this->accessTokenRepository = $accessTokenRepository;
        $this->accessTokenFactory = $accessTokenFactory;
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

    /**
     * @param string $accessToken
     *
     * @return AccessToken|null
     */
    public function findAccessToken(string $accessToken): ?AccessToken
    {
        return $this->accessTokenFactory->fromToken($accessToken);
    }
}
