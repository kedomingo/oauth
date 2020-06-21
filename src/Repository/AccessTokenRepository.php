<?php declare(strict_types=1);

namespace KOA2\Repository;

use KOA2\Model\Token;
use KOA2\Persistence\AccessTokenInterface;

class AccessTokenRepository implements AccessTokenRepositoryInterface
{
    /**
     * @var AccessTokenInterface
     */
    private $persistence;

    /**
     * ClientRepository constructor.
     *
     * @param AccessTokenInterface $persistence
     */
    public function __construct(AccessTokenInterface $persistence)
    {
        $this->persistence = $persistence;
    }

    /**
     * @param string $token
     * @return Token|null
     */
    public function findToken(string $token): ?Token
    {
        $tokenDTO = $this->persistence->findToken($token);

        if ($tokenDTO === null) {
            return null;
        }

        return new Token(
            $tokenDTO->getId(),
            null,
            $tokenDTO->getUserId(),
            $tokenDTO->getClientId(),
            $tokenDTO->getScopes(),
            $tokenDTO->getExpiresAt(),
            null
        );
    }

    /**
     * @param Token $token
     */
    public function issueToken(Token $token): void
    {
        $this->persistence->persist(
            $token->getId(),
            $token->getRefreshToken(),
            $token->getUserId(),
            $token->getClientId(),
            $token->getScopes(),
            $token->getExpiresAt(),
            $token->getRefreshExpiresAt(),
        );
    }

}