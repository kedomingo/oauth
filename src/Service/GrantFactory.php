<?php declare(strict_types=1);

namespace KOA2\Service;

use KOA2\Model\Token;
use KOA2\Repository\AccessTokenRepository;
use Laravel\Lumen\Application;

final class GrantFactory
{
    public const GRANT_TYPE_AUTHORIZATION_CODE = 'auth_code';
    public const GRANT_TYPE_REFRESH_TOKEN = 'refresh_token';

    /**
     * @var Application
     */
    private $app;

    public function __construct(Application  $app)
    {
        $this->app = $app;
    }

    public function createGrant(string $grantType)
    {

        switch ($grantType) {
            case self::GRANT_TYPE_AUTHORIZATION_CODE:
                return $this->app->make(AuthCodeGrantProvider::class);

            case self::GRANT_TYPE_REFRESH_TOKEN:
                return $this->app->make(RefreshTokenGrantProvider::class);
        }
    }

}