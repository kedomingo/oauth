<?php declare(strict_types=1);

namespace KOA2\Repository;

use KOA2\Model\AuthCode;
use KOA2\Persistence\Contract\AuthCodePersistence;
use KOA2\Repository\Contract\AuthCodeRepositoryInterface;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;

class AuthCodeRepository implements AuthCodeRepositoryInterface
{
    /**
     * @var AuthCodePersistence
     */
    private $authCodePersistence;

    /**
     * AuthCodeRepository constructor.
     * @param AuthCodePersistence $authCodePersistence
     */
    public function __construct(AuthCodePersistence $authCodePersistence)
    {
        $this->authCodePersistence = $authCodePersistence;
    }

    /**
     * Creates a new AuthCode
     *
     * @return AuthCodeEntityInterface
     */
    public function getNewAuthCode(): AuthCodeEntityInterface
    {
        return new AuthCode();
    }

    /**
     * Persists a new auth code to permanent storage.
     *
     * @param AuthCodeEntityInterface $authCodeEntity
     *
     * @return void
     * @throws UniqueTokenIdentifierConstraintViolationException
     */
    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity): void
    {
        $this->authCodePersistence->persistNewAuthCode($authCodeEntity);
    }

    /**
     * Revoke an auth code.
     *
     * @param string $codeId
     *
     * @return void
     */
    public function revokeAuthCode($codeId): void
    {
        $this->authCodePersistence->revokeAuthCode($codeId);
    }

    /**
     * Check if the auth code has been revoked.
     *
     * @param string $codeId
     *
     * @return bool Return true if this code has been revoked
     */
    public function isAuthCodeRevoked($codeId): bool
    {
        $this->authCodePersistence->isAuthCodeRevoked($codeId);
    }
}