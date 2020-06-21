<?php declare(strict_types=1);
/**
 * @author    Kyle Domingo <kdomingo@wayfair.com>
 * @copyright 2020 Wayfair LLC - All rights reserved
 */

namespace KOA2\Persistence;

use KOA2\DTO\TokenDTO;

interface AccessTokenInterface
{
    /**
     * @param string $token
     * @return TokenDTO|null
     */
    public function findToken(string $token): ?TokenDTO;

    /**
     * @param string $token
     * @param string $refreshToken
     * @param int $userId
     * @param int $clientId
     * @param string $scopes
     * @param string $expiresAt
     * @param string $refreshExpiresAt
     */
    public function persist(
        string $token,
        string $refreshToken,
        int $userId,
        int $clientId,
        string $scopes,
        string $expiresAt,
        string $refreshExpiresAt
    ): void;

}