<?php declare(strict_types=1);

namespace KOA2\Persistence;

use KOA2\DTO\ClientDTO;
use KOA2\DTO\TokenDTO;
use KOA2\Exception\DTOHydrationException;
use KOA2\Schema\ClientSchema;
use DB;
use KOA2\Schema\RefreshTokenSchema;
use KOA2\Schema\TokenSchema;

final class AccessToken implements AccessTokenInterface
{
    use HydratesDTOTrait;

    /**
     * @param string $token
     * @return TokenDTO|null
     * @throws DTOHydrationException
     */
    public function findToken(string $token): ?TokenDTO
    {
        $result = DB::table(TokenSchema::getTablename())
            ->where(TokenSchema::tokenId(), '=', $token)
            ->first();

        return $result === null ? null : $this->hydrateOne(TokenDTO::class, $result);
    }

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
    ): void
    {
        DB::table(TokenSchema::getTablename())
            ->insert(
                [
                    TokenSchema::tokenId() => $token,
                    TokenSchema::userId() => $userId,
                    TokenSchema::clientId() => $clientId,
                    TokenSchema::scopes() => $scopes,
                    TokenSchema::expiresAt() => $expiresAt,
                ]
            );

        DB::table(RefreshTokenSchema::getTablename())
            ->insert(
                [
                    RefreshTokenSchema::tokenId() => $refreshToken,
                    RefreshTokenSchema::accessTokenId() => $token,
                    TokenSchema::expiresAt() => $refreshExpiresAt,
                ]
            );
    }
}