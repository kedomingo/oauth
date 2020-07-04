<?php declare(strict_types=1);

namespace KOA2\Persistence\DB;

use KOA2\Model\AccessToken as AccessTokenModel;
use KOA2\PDO\PDOConnection;
use KOA2\Persistence\Contract\AccessTokenPersistence;
use KOA2\Repository\Contract\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use PDO;
use PDOException;
use Exception;

final class AccessToken implements AccessTokenPersistence
{
    use QueriesPDO;
    use Revocable;

    private const ACCESS_TOKEN_TABLE = 'oauth_access_tokens';

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
     * Persists a new access token to permanent storage.
     *
     * @param AccessTokenEntityInterface $accessToken
     *
     * @return void
     * @throws UniqueTokenIdentifierConstraintViolationException
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessToken): void
    {
        $sql = '
            INSERT INTO oauth_access_tokens (
                   id,
                   user_id,
                   client_id,
                   scopes,
                   created_at,
                   expires_at
                   ) VALUES (
                     :id,
                     :userId,
                     :clientId,
                     :scopes,
                     :createdAt,
                     :expiresAt
                   )
         ';

        try {
            $this->query(
                $this->pdo,
                $sql,
                [
                    'id'        => $accessToken->getIdentifier(),
                    'userId'    => $accessToken->getUserIdentifier(),
                    'clientId'  => $accessToken->getClientAsString(),
                    'scopes'    => $accessToken->getScopesAsString(),
                    'createdAt' => date('Y-m-d H:i:s'),
                    'expiresAt' => $accessToken->getExpiryDateTime()->format('Y-m-d H:i:s'),
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
     * Revoke an access token.
     *
     * @param string $tokenId
     *
     * @return void
     * @throws Exception
     */
    public function revokeAccessToken($tokenId): void
    {
        $this->revoke($this->pdo, self::ACCESS_TOKEN_TABLE, $tokenId);
    }

    /**
     * Check if the access token has been revoked.
     *
     * @param string $tokenId
     *
     * @return bool Return true if this token has been revoked
     * @throws Exception
     */
    public function isAccessTokenRevoked($tokenId): bool
    {
        return $this->isRevoked($this->pdo, self::ACCESS_TOKEN_TABLE, $tokenId);
    }
}