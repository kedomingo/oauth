<?php declare(strict_types=1);

namespace KOA2\Persistence\Contract;

use KOA2\DTO\RefreshTokenDTO;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;

interface RefreshTokenPersistence
{
    /**
     * Create a new refresh token_name.
     *
     * @param RefreshTokenEntityInterface $refreshTokenEntity
     *
     * @return void
     * @throws UniqueTokenIdentifierConstraintViolationException
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity): void;

    /**
     * Revoke the refresh token.
     *
     * @param string $tokenId
     *
     * @return void
     */
    public function revokeRefreshToken($tokenId): void;

    /**
     * Check if the refresh token has been revoked.
     *
     * @param string $tokenId
     *
     * @return bool Return true if this token has been revoked
     */
    public function isRefreshTokenRevoked($tokenId): bool;
}