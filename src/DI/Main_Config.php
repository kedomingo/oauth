<?php declare(strict_types=1);

namespace KOA2\DI;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use KOA2\PDO\PDOConnection;
use KOA2\PDO\ConnectionConfigurationProvider;
use KOA2\PDO\ConnectionConfigurationProviderInterface;
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
use KOA2\Repository\Contract\ClientRepositoryInterface;
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
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function DI\autowire;
use function DI\get;

return [
    // DB
    ConnectionConfigurationProviderInterface::class => get(ConnectionConfigurationProvider::class),
    PDOConnectionInterface::class                   => get(PDOConnection::class),
    // Hasher
    PasswordHasherInterface::class                  => get(BcryptPasswordHasher::class),

    // Repository
    AccessTokenRepositoryInterface::class           => get(AccessTokenRepository::class),
    AuthCodeRepositoryInterface::class              => get(AuthCodeRepository::class),
    ClientRepositoryInterface::class                => get(ClientRepository::class),
    RefreshTokenRepositoryInterface::class          => get(RefreshTokenRepository::class),
    ScopeRepositoryInterface::class                 => get(ScopeRepository::class),
    UserRepositoryInterface::class                  => get(UserRepository::class),

    // Persistence
    AccessTokenPersistenceInterface::class          => get(AccessTokenPersistence::class),
    AuthCodePersistenceInterface::class             => get(AuthCodePersistence::class),
    ClientPersistenceInterface::class               => get(ClientPersistence::class),
    RefreshTokenPersistenceInterface::class         => get(RefreshTokenPersistence::class),
    ScopePersistenceInterface::class                => get(ScopePersistence::class),
    UserPersistenceInterface::class                 => get(UserPersistence::class),

    // Http
    ServerRequestInterface::class                   => function () {
        return ServerRequest::fromGlobals();
    },
    ResponseInterface::class                        => get(Response::class),

    // Services
    OauthServerProviderInterface::class             => get(OauthServerProvider::class),
    AccessTokenProviderInterface::class             => get(AccessTokenProvider::class),
    AuthorizerInterface::class                      => get(Authorizer::class),
];