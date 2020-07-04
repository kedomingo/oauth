<?php declare(strict_types=1);

namespace KOA2\Persistence\DB;

use KOA2\DTO\RefreshTokenDTO;
use KOA2\PDO\PDOConnection;
use KOA2\Persistence\Contract\RefreshTokenPersistence;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use PDO;
use PDOException;
use Exception;

final class RefreshToken implements RefreshTokenPersistence
{
    use QueriesPDO;
    use Revocable;

    private const REFRESH_TOKEN_TABLE = 'oauth_refresh_tokens';

    /**
     * @var PDO
     */
    private $pdo;

    /**
     * Client constructor.
     * @param PDOConnection $connection
     */
    public function __construct(PDOConnection $connection)
    {
        $this->pdo = $connection->getPDO();
    }

    /**
     * Create a new refresh token_name.
     *
     * @param RefreshTokenEntityInterface $refreshToken
     *
     * @return void
     * @throws UniqueTokenIdentifierConstraintViolationException
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshToken): void
    {
        $sql = '
            INSERT INTO oauth_refresh_tokens (
                   id,
                   access_token_id,
                   expires_at
                   ) VALUES (
                     :id,
                     :accessTokenId,
                     :expiresAt
                   )
         ';

        try {
            $this->query(
                $this->pdo,
                $sql,
                [
                    'id'            => $refreshToken->getIdentifier(),
                    'accessTokenId' => $refreshToken->getAccessToken(),
                    'expiresAt'     => $refreshToken->getExpiryDateTime()->format('Y-m-d H:i:s'),
                ]
            );
        } catch (PDOException $e) {
            // TODO LOG
            if ($this->isDuplicateError($e->getMessage())) {
                throw UniqueTokenIdentifierConstraintViolationException::create();
            }
        }
    }

    /**
     * Revoke the refresh token.
     *
     * @param string $tokenId
     *
     * @return void
     * @throws Exception
     */
    public function revokeRefreshToken($tokenId): void
    {
        $this->revoke($this->pdo, self::REFRESH_TOKEN_TABLE, $tokenId);
    }

    /**
     * Check if the refresh token has been revoked.
     *
     * @param string $tokenId
     *
     * @return bool Return true if this token has been revoked
     * @throws Exception
     */
    public function isRefreshTokenRevoked($tokenId): bool
    {
        return $this->isRevoked($this->pdo, self::REFRESH_TOKEN_TABLE, $tokenId);
    }
}