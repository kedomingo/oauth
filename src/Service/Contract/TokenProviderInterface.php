<?php declare(strict_types=1);

namespace KOA2\Service\Contract;

use KOA2\Model\Token;

interface TokenProviderInterface
{
    /**
     * @param string $token
     * @return Token|bool
     */
    public function isTokenValid(string $token);

    /**
     * @param Token $token
     */
    public function issueToken(Token $token) : void;
}