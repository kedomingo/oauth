<?php declare(strict_types=1);

namespace KOA2\Repository;

use KOA2\DTO\AccessTokenDTO;
use KOA2\Model\AccessToken;
use KOA2\Persistence\Contract\AccessTokenPersistence;
use KOA2\Repository\Contract\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;

class AccessTokenRepository implements AccessTokenRepositoryInterface
{
    /**
     * @var AccessTokenPersistence
     */
    private $accessTokenPersistence;

    /**
     * AccessTokenRepository constructor.
     * @param AccessTokenPersistence $accessTokenPersistence
     */
    public function __construct(AccessTokenPersistence $accessTokenPersistence)
    {
        $this->accessTokenPersistence = $accessTokenPersistence;
    }

    /**
     * Create a new access token
     *
     * @param ClientEntityInterface  $client
     * @param ScopeEntityInterface[] $scopes
     * @param string                 $userId
     *
     * @return AccessTokenEntityInterface
     */
    public function getNewToken(
        ClientEntityInterface $client,
        array $scopes,
        $userId = null
    ): AccessTokenEntityInterface {
        return new AccessToken($client, $scopes, $userId);
    }

    /**
     * Persists a new access token to permanent storage.
     *
     * @param AccessTokenEntityInterface $accessTokenEntity
     *
     * @return void
     * @throws UniqueTokenIdentifierConstraintViolationException
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity): void
    {
        $this->accessTokenPersistence->persistNewAccessToken($accessTokenEntity);
    }

    /**
     * Revoke an access token.
     *
     * @param string $tokenId
     *
     * @return void
     */
    public function revokeAccessToken($tokenId): void
    {
        $this->accessTokenPersistence->revokeAccessToken($tokenId);
    }

    /**
     * Check if the access token has been revoked.
     *
     * @param string $tokenId
     *
     * @return bool Return true if this token has been revoked
     */
    public function isAccessTokenRevoked($tokenId): bool
    {
        return $this->accessTokenPersistence->isAccessTokenRevoked($tokenId);
    }

    /**
     * Get an AccessToken model from an access token identifier
     *
     * @param $id
     *
     * @return AccessTokenDTO|null
     */
    public function findByIdentifier(string $tokenId): ?AccessTokenDTO {
        return $this->accessTokenPersistence->findByIdentifier($tokenId);
    }
}
