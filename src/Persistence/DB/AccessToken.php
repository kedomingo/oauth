<?php declare(strict_types=1);

namespace KOA2\Persistence\DB;

use KOA2\Model\AccessToken as AccessTokenModel;
use KOA2\PDO\Connection;
use KOA2\Persistence\Contract\AccessTokenPersistence;
use KOA2\Repository\Contract\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use PDO;
use PDOException;

final class AccessToken implements AccessTokenPersistence
{
    use QueriesPDO;

    /**
     * @var PDO
     */
    private $pdo;

    /**
     * Client constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->pdo = $connection->getConnection();
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
            echo $e->getMessage();exit;
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
     */
    public function revokeAccessToken($tokenId): void
    {
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
    }
}