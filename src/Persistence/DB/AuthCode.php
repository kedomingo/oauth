<?php declare(strict_types=1);

namespace KOA2\Persistence\DB;

use Exception;
use KOA2\DTO\AuthCodeDTO;
use KOA2\PDO\PDOConnection;
use KOA2\Persistence\Contract\AuthCodePersistence;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use PDO;
use PDOException;

final class AuthCode implements AuthCodePersistence
{
    use QueriesPDO;
    use Revocable;

    private const DUPLICATE_AUTH_CODE_PATTERN = '/Integrity constraint violation.*Duplicate entry/i';
    private const AUTH_CODES_TABLE = 'oauth_auth_codes';
    private const AUTH_CODE_COLUMN = 'auth_code';

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
        $existing = $this->getAuthcodeByCode($authCode->getIdentifier());
        if ($existing !== null) {
            throw UniqueTokenIdentifierConstraintViolationException::create();
        }

        $sql = '
            INSERT INTO oauth_auth_codes (
                   auth_code,
                   user_id,
                   client_id,
                   scopes,
                   expires_at
                   ) VALUES (
                     :authCode,
                     :userId,
                     :clientId,
                     :scopes,
                     :expiry
                   )
         ';

        try {
            $this->query(
                $this->pdo,
                $sql,
                [
                    'authCode' => $authCode->getIdentifier(),
                    'userId'   => $authCode->getUserIdentifier(),
                    'clientId' => $authCode->getClientAsString(),
                    'scopes'   => $authCode->getScopesAsString(),
                    'expiry'   => $authCode->getExpiryDateTime()->format('Y-m-d H:i:s'),
                ]
            );
        } catch (PDOException $e) {
            // TODO logging
            throw $e;
        }
    }

    /**
     * @param string $code
     * @return AuthCodeDTO|null
     * @throws Exception
     */
    public function getAuthcodeByCode(string $code): ?AuthCodeDTO
    {
        $sql = '
            SELECT id
              FROM oauth_auth_codes
             WHERE auth_code = :authCode
        ';
        $statement = $this->query($this->pdo, $sql, ['authCode' => $code]);

        return $statement->fetchObject(AuthCodeDTO::class) ?: null;
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
        $this->revoke($this->pdo, self::AUTH_CODES_TABLE, $codeId, self::AUTH_CODE_COLUMN);
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
        return $this->isRevoked($this->pdo, self::AUTH_CODES_TABLE, $codeId);
    }
}