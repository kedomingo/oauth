<?php

namespace KOA2\DI;

use Illuminate\Support\ServiceProvider;
use KOA2\PDO\ConnectionConfigurationProvider;
use KOA2\PDO\ConnectionConfigurationProviderInterface;
use KOA2\PDO\PDOConnection;
use KOA2\PDO\PDOConnectionInterface;
use KOA2\Persistence\Contract\AccessTokenPersistence as AccessTokenPersistenceInterface;
use KOA2\Persistence\Contract\AuthCodePersistence as AuthCodePersistenceInterface;
use KOA2\Persistence\Contract\ClientPersistence as ClientPersistenceInterface;
use KOA2\Persistence\Contract\RefreshTokenPersistence as RefreshTokenPersistenceInterface;
use KOA2\Persistence\Contract\ScopePersistence as ScopePersistenceInterface;
use KOA2\Persistence\Contract\UserPersistence as UserPersistenceInterface;
use KOA2\Persistence\DB\AccessToken as AccessTokenPersistence;
use KOA2\Persistence\DB\AuthCode as AuthCodePersistence;
use KOA2\Persistence\DB\Client as ClientPersistence;
use KOA2\Persistence\DB\RefreshToken as RefreshTokenPersistence;
use KOA2\Persistence\DB\Scope as ScopePersistence;
use KOA2\Persistence\DB\User as UserPersistence;
use KOA2\Repository\AccessTokenRepository;
use KOA2\Repository\AuthCodeRepository;
use KOA2\Repository\ClientRepository;
use KOA2\Repository\Contract\AccessTokenRepositoryInterface;
use KOA2\Repository\Contract\AuthCodeRepositoryInterface;
use KOA2\Repository\Contract\RefreshTokenRepositoryInterface;
use KOA2\Repository\Contract\ScopeRepositoryInterface;
use KOA2\Repository\Contract\UserRepositoryInterface;
use KOA2\Repository\RefreshTokenRepository;
use KOA2\Repository\ScopeRepository;
use KOA2\Repository\UserRepository;
use KOA2\Service\AccessTokenProvider;
use KOA2\Service\Authorizer;
use KOA2\Service\BcryptPasswordHasher;
use KOA2\Service\Contract\AccessTokenProviderInterface;
use KOA2\Service\Contract\AuthorizerInterface;
use KOA2\Service\Contract\OauthServerProviderInterface;
use KOA2\Service\Contract\PasswordHasherInterface;
use KOA2\Service\OauthServerProvider;

class OauthServiceProvider extends ServiceProvider
{
    /**s
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // DB
        $this->app->bind(ConnectionConfigurationProviderInterface::class, ConnectionConfigurationProvider::class);
        $this->app->bind(PDOConnectionInterface::class, PDOConnection::class);
        // Hasher
        $this->app->bind(PasswordHasherInterface::class, BcryptPasswordHasher::class);

        // Repository
        $this->app->bind(AccessTokenRepositoryInterface::class, AccessTokenRepository::class);
        $this->app->bind(AuthCodeRepositoryInterface::class, AuthCodeRepository::class);
        $this->app->bind(\KOA2\Repository\Contract\ClientRepositoryInterface::class, ClientRepository::class);
        $this->app->bind(RefreshTokenRepositoryInterface::class, RefreshTokenRepository::class);
        $this->app->bind(ScopeRepositoryInterface::class, ScopeRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        // Persistence
        $this->app->bind(AccessTokenPersistenceInterface::class, AccessTokenPersistence::class);
        $this->app->bind(AuthCodePersistenceInterface::class, AuthCodePersistence::class);
        $this->app->bind(ClientPersistenceInterface::class, ClientPersistence::class);
        $this->app->bind(RefreshTokenPersistenceInterface::class, RefreshTokenPersistence::class);
        $this->app->bind(ScopePersistenceInterface::class, ScopePersistence::class);
        $this->app->bind(UserPersistenceInterface::class, UserPersistence::class);

        // Services
        $this->app->bind(OauthServerProviderInterface::class, OauthServerProvider::class);
        $this->app->bind(AccessTokenProviderInterface::class, AccessTokenProvider::class);
        $this->app->bind(AuthorizerInterface::class, Authorizer::class);
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
    }
}
