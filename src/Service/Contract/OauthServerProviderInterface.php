<?php declare(strict_types=1);

namespace KOA2\Service\Contract;

use DateInterval;
use League\OAuth2\Server\AuthorizationServer;

interface OauthServerProviderInterface
{
    public function getServer(): AuthorizationServer;

    public function enableClientCredentialsGrant(DateInterval $tokenValidityInterval = null): void;

    public function enableAuthCodeGrant(DateInterval $tokenValidityInterval = null): void;

    public function enableRefreshTokenGrant(DateInterval $tokenValidityInterval = null): void;

    public function enablePasswordGrant(DateInterval $tokenValidityInterval = null): void;
}
