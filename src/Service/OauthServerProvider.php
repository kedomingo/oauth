<?php declare(strict_types=1);

namespace KOA2\Service;

use DateInterval;
use Exception;
use KOA2\Repository\Contract\AccessTokenRepositoryInterface;
use KOA2\Repository\Contract\AuthCodeRepositoryInterface;
use KOA2\Repository\Contract\ClientRepositoryInterface;
use KOA2\Repository\Contract\RefreshTokenRepositoryInterface;
use KOA2\Repository\Contract\ScopeRepositoryInterface;
use KOA2\Repository\Contract\UserRepositoryInterface;
use KOA2\Service\Contract\OauthServerProviderInterface;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\AuthCodeGrant;
use League\OAuth2\Server\Grant\ClientCredentialsGrant;
use League\OAuth2\Server\Grant\RefreshTokenGrant;
use League\OAuth2\Server\Grant\PasswordGrant;

class OauthServerProvider implements OauthServerProviderInterface
{
    // 1 hour
    private const DEFAULT_TOKEN_EXPIRY_INTERVAL_SPEC = 'PT1H';
    // 10 minutes
    private const DEFAULT_AUTHCODE_EXPIRY_INTERVAL_SPEC = 'PT10M';
    // 1 month
    private const DEFAULT_REFRESH_TOKEN_EXPIRY_INTERVAL_SPEC = 'P1M';

    /**
     * @var ClientRepositoryInterface
     */
    private $clientRepository;

    /**
     * @var AccessTokenRepositoryInterface
     */
    private $accessTokenRepository;

    /**
     * @var ScopeRepositoryInterface
     */
    private $scopeRepository;

    /**
     * @var AuthCodeRepositoryInterface
     */
    private $authCodeRepository;

    /**
     * @var RefreshTokenRepositoryInterface
     */
    private $refreshTokenRepository;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var AuthorizationServer
     */
    private static $serverSingleton;

    /**
     * OauthServerProvider constructor.
     *
     * @param ClientRepositoryInterface       $clientRepository
     * @param ScopeRepositoryInterface        $scopeRepository
     * @param AccessTokenRepositoryInterface  $accessTokenRepository
     * @param AuthCodeRepositoryInterface     $authCodeRepository
     * @param RefreshTokenRepositoryInterface $refreshTokenRepository
     */
    public function __construct(
        ClientRepositoryInterface $clientRepository,
        ScopeRepositoryInterface $scopeRepository,
        AccessTokenRepositoryInterface $accessTokenRepository,
        AuthCodeRepositoryInterface $authCodeRepository,
        RefreshTokenRepositoryInterface $refreshTokenRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->clientRepository = $clientRepository;
        $this->accessTokenRepository = $accessTokenRepository;
        $this->scopeRepository = $scopeRepository;
        $this->authCodeRepository = $authCodeRepository;
        $this->refreshTokenRepository = $refreshTokenRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @return AuthorizationServer
     * @throws Exception
     */
    public function getServer(): AuthorizationServer
    {
        if (static::$serverSingleton !== null) {
            return static::$serverSingleton;
        }

        $privateKey = getenv('OAUTH_PRIVATE_KEY');
        $encryptionKey = getenv('APP_KEY');

        // Setup the authorization server
        static::$serverSingleton = new AuthorizationServer(
            $this->clientRepository,
            $this->accessTokenRepository,
            $this->scopeRepository,
            $privateKey,
            $encryptionKey
        );

        $this->enableAuthCodeGrant();
        $this->enableClientCredentialsGrant();
        $this->enableRefreshTokenGrant();
        $this->enablePasswordGrant();

        return static::$serverSingleton;
    }

    /**
     * @param DateInterval|null $tokenValidityInterval
     *
     * @return void
     * @throws Exception
     */
    public function enableClientCredentialsGrant(DateInterval $tokenValidityInterval = null): void
    {
        if ($tokenValidityInterval === null) {
            $tokenValidityInterval = new DateInterval(self::DEFAULT_TOKEN_EXPIRY_INTERVAL_SPEC);
        }

        static::$serverSingleton->enableGrantType(
            new ClientCredentialsGrant(),
            $tokenValidityInterval
        );
    }

    /**
     * @param DateInterval|null $tokenValidityInterval
     *
     * @return void
     * @throws Exception
     */
    public function enableAuthCodeGrant(DateInterval $tokenValidityInterval = null): void
    {
        if ($tokenValidityInterval === null) {
            $tokenValidityInterval = new DateInterval(self::DEFAULT_TOKEN_EXPIRY_INTERVAL_SPEC);
        }

        $authCodeExpiry = new DateInterval(self::DEFAULT_AUTHCODE_EXPIRY_INTERVAL_SPEC);
        $refreshTokenExpiry = new DateInterval(self::DEFAULT_REFRESH_TOKEN_EXPIRY_INTERVAL_SPEC);
        $authCodeGrant = new AuthCodeGrant($this->authCodeRepository, $this->refreshTokenRepository, $authCodeExpiry);
        $authCodeGrant->setRefreshTokenTTL($refreshTokenExpiry);

        static::$serverSingleton->enableGrantType($authCodeGrant, $tokenValidityInterval);
    }

    /**
     * @param DateInterval|null $tokenValidityInterval
     *
     * @return void
     * @throws Exception
     */
    public function enableRefreshTokenGrant(DateInterval $tokenValidityInterval = null): void
    {
        if ($tokenValidityInterval === null) {
            $tokenValidityInterval = new DateInterval(self::DEFAULT_TOKEN_EXPIRY_INTERVAL_SPEC);
        }

        $refreshTokenExpiry = new DateInterval(self::DEFAULT_REFRESH_TOKEN_EXPIRY_INTERVAL_SPEC);
        $refreshTokenGrant = new RefreshTokenGrant($this->refreshTokenRepository);
        $refreshTokenGrant->setRefreshTokenTTL($refreshTokenExpiry);

        static::$serverSingleton->enableGrantType($refreshTokenGrant, $tokenValidityInterval);
    }

    /**
     * @param DateInterval|null $tokenValidityInterval
     *
     * @return void
     * @throws Exception
     */
    public function enablePasswordGrant(DateInterval $tokenValidityInterval = null): void
    {
        if ($tokenValidityInterval === null) {
            $tokenValidityInterval = new DateInterval(self::DEFAULT_TOKEN_EXPIRY_INTERVAL_SPEC);
        }

        $refreshTokenExpiry = new DateInterval(self::DEFAULT_REFRESH_TOKEN_EXPIRY_INTERVAL_SPEC);
        $passwordGrant = new PasswordGrant($this->userRepository, $this->refreshTokenRepository);
        $passwordGrant->setRefreshTokenTTL($refreshTokenExpiry);

        static::$serverSingleton->enableGrantType($passwordGrant, $tokenValidityInterval);
    }
}
