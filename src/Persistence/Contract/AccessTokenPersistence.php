<?php declare(strict_types=1);

namespace KOA2\Persistence\Contract;

use KOA2\DTO\AccessTokenDTO;
use KOA2\Model\AccessToken;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;

interface AccessTokenPersistence
{
    /**
     * Persists a new access token to permanent storage.
     *
     * @param AccessTokenEntityInterface $accessToken
     *
     * @return void
     * @throws UniqueTokenIdentifierConstraintViolationException
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessToken): void;

    /**
     * Revoke an access token.
     *
     * @param string $tokenId
     *
     * @return void
     */
    public function revokeAccessToken($tokenId): void;

    /**
     * Check if the access token has been revoked.
     *
     * @param string $tokenId
     *
     * @return bool Return true if this token has been revoked
     */
    public function isAccessTokenRevoked($tokenId): bool;

    /**
     * @param string $id
     *
     * @return AccessTokenDTO
     */
    public function findByIdentifier(string $id): AccessTokenDTO;
}
