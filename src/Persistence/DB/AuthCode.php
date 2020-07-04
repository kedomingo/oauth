<?php declare(strict_types=1);

namespace KOA2\Persistence\DB;

use Exception;
use KOA2\Model\AuthCode as AuthCodeModel;
use KOA2\PDO\Connection;
use KOA2\Persistence\Contract\AuthCodePersistence;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use PDO;
use PDOException;

final class AuthCode implements AuthCodePersistence
{
    use QueriesPDO;

    private const DUPLICATE_AUTH_CODE_PATTERN = '/Integrity constraint violation.*Duplicate entry/i';

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
     * Persists a new auth code to permanent storage.
     *
     * @param AuthCodeEntityInterface $authCode
     *
     * @return void
     * @throws UniqueTokenIdentifierConstraintViolationException
     * @throws Exception
     */
    public function persistNewAuthCode(AuthCodeEntityInterface $authCode): void
    {
        $sql = '
            INSERT INTO oauth_auth_codes (
                   id,
                   user_id,
                   client_id,
                   scopes
                   ) VALUES (
                     :id,
                     :userId,
                     :clientId,
                     :scopes 
                   )
         ';

        try {
            $this->query(
                $this->pdo,
                $sql,
                [
                    'id'       => $authCode->getIdentifier(),
                    'userId'   => $authCode->getUserIdentifier(),
                    'clientId' => $authCode->getClientAsString(),
                    'scopes'   => $authCode->getScopesAsString(),
                ]
            );
        } catch (PDOException $e) {
            if (preg_match(self::DUPLICATE_AUTH_CODE_PATTERN, $e->getMessage())) {
                throw UniqueTokenIdentifierConstraintViolationException::create();
            }
        }
    }

    /**
     * Revoke an auth code.
     *
     * @param string $codeId
     *
     * @return void
     * @throws Exception
     */
    public function revokeAuthCode($codeId): void
    {
        $sql = '
            UPDATE oauth_auth_codes
               SET revoked = :revoked
             WHERE id = :id
         ';

        $this->query(
            $this->pdo,
            $sql,
            [
                'revoked' => 1,
                'id'      => $codeId
            ]
        );
    }

    /**
     * Check if the auth code has been revoked.
     *
     * @param string $codeId
     *
     * @return bool Return true if this code has been revoked
     * @throws Exception
     */
    public function isAuthCodeRevoked($codeId): bool
    {
        $sql = '
            SELECT revoked
              FROM oauth_auth_codes
             WHERE id = :id
         ';

        $statement = $this->query($this->pdo, $sql, ['id' => $codeId]);

        return (bool)$statement->fetchColumn();
    }
}