<?php declare(strict_types=1);

namespace KOA2\Persistence\Contract;

use KOA2\DTO\AuthCodeDTO;
use KOA2\Model\AuthCode;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;

interface AuthCodePersistence
{
    /**
     * Persists a new auth code to permanent storage.
     *
     * @param AuthCodeEntityInterface $authCode
     *
     * @return void
     * @throws UniqueTokenIdentifierConstraintViolationException
     */
    public function persistNewAuthCode(AuthCodeEntityInterface $authCode): void;

    /**
     * Revoke an auth code.
     *
     * @param string $codeId
     *
     * @return void
     */
    public function revokeAuthCode($codeId): void;

    /**
     * Check if the auth code has been revoked.
     *
     * @param string $codeId
     *
     * @return bool Return true if this code has been revoked
     */
    public function isAuthCodeRevoked($codeId): bool;
}