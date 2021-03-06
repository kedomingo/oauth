<?php declare(strict_types=1);

namespace KOA2\Repository;

use KOA2\Model\RefreshToken;
use KOA2\Persistence\Contract\RefreshTokenPersistence;
use KOA2\Repository\Contract\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;

class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{
    /**
     * @var RefreshTokenPersistence
     */
    private $refreshTokenPersistence;

    /**
     * RefreshTokenRepository constructor.
     * @param RefreshTokenPersistence $refreshTokenPersistence
     */
    public function __construct(RefreshTokenPersistence $refreshTokenPersistence)
    {
        $this->refreshTokenPersistence = $refreshTokenPersistence;
    }

    /**
     * Creates a new refresh token
     *
     * @return RefreshTokenEntityInterface|null
     */
    public function getNewRefreshToken(): ?RefreshTokenEntityInterface
    {
        return new RefreshToken();
    }

    /**
     * Create a new refresh token_name.
     *
     * @param RefreshTokenEntityInterface $refreshTokenEntity
     *
     * @return void
     * @throws UniqueTokenIdentifierConstraintViolationException
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity): void
    {
        $this->refreshTokenPersistence->persistNewRefreshToken($refreshTokenEntity);
    }

    /**
     * Revoke the refresh token.
     *
     * @param string $tokenId
     *
     * @return void
     */
    public function revokeRefreshToken($tokenId): void
    {
        $this->refreshTokenPersistence->revokeRefreshToken($tokenId);
    }

    /**
     * Check if the refresh token has been revoked.
     *
     * @param string $tokenId
     *
     * @return bool Return true if this token has been revoked
     */
    public function isRefreshTokenRevoked($tokenId): bool
    {
        return $this->refreshTokenPersistence->isRefreshTokenRevoked($tokenId);
    }
}