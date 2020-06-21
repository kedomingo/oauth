<?php declare(strict_types=1);

namespace KOA2\Service;

use KOA2\Model\Token;

final class RefreshTokenGrantProvider extends AbstractGrantProvider
{
    /**
     * @param array $parameters
     * @return Token
     */
    public function grantToken(array $parameters) : Token {

    }
}