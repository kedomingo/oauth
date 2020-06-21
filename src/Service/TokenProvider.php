<?php declare(strict_types=1);

namespace KOA2\Service;

use KOA2\Model\Token;
use KOA2\Repository\AccessTokenRepository;

class TokenProvider implements TokenProviderInterface
{
    /**
     * @var AccessTokenRepository
     */
    private $tokenRepository;

    /**
     * TokenProvider constructor.
     * @param AccessTokenRepository $tokenRepository
     */
    public function __construct(AccessTokenRepository $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

    /**
     * @param string $token
     * @return Token|bool
     */
    public function isTokenValid(string $token)
    {
        $token = $this->tokenRepository->findToken($token);
        if (!$token || !$token->isValid()) {
            return false;
        }

        return $token;
    }

    public function issueToken(Token $token) : void {
        $this->tokenRepository->issueToken($token);
    }
}