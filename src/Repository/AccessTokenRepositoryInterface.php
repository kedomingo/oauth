<?php declare(strict_types=1);

namespace KOA2\Repository;

use KOA2\Model\Token;

interface AccessTokenRepositoryInterface
{
    /**
     * @param string $token
     * @return Token|null
     */
    public function findToken(string $token): ?Token;

    /**
     * @param Token $token
     */
    public function issueToken(Token $token): void;
}