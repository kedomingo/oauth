<?php declare(strict_types=1);

namespace KOA2\Service\Contract;

use KOA2\Model\AccessToken;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ResponseInterface;

interface AccessTokenProviderInterface
{
    /**
     * @return ResponseInterface
     * @throws OAuthServerException
     */
    public function getAccessToken(): ResponseInterface;

    /**
     * @param string $accessToken
     *
     * @return AccessToken|null
     */
    public function findAccessToken(string $accessToken) : ?AccessToken;
}
