<?php

namespace KOA2\DI;

use Illuminate\Support\ServiceProvider;
use KOA2\Persistence\AccessToken;
use KOA2\Persistence\AccessTokenInterface;
use KOA2\Persistence\Client;
use KOA2\Persistence\ClientInterface;
use KOA2\Repository\ClientRepository;
use KOA2\Repository\ClientRepositoryInterface;
use KOA2\Service\ClientAuthenticator;
use KOA2\Service\ClientAuthenticatorInterface;
use KOA2\Service\ClientAuthorizer;
use KOA2\Service\ClientAuthorizerInterface;
use KOA2\Service\EncryptionKeyProvider;
use KOA2\Service\EncryptionKeyProviderInterface;
use KOA2\Service\TokenProvider;
use KOA2\Service\TokenProviderInterface;

class OauthServiceProvider extends ServiceProvider
{
    /**s
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EncryptionKeyProviderInterface::class, EncryptionKeyProvider::class);

        $this->app->bind(ClientAuthorizerInterface::class, ClientAuthorizer::class);
        $this->app->bind(ClientAuthenticatorInterface::class, ClientAuthenticator::class);
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
        $this->app->bind(ClientInterface::class, Client::class);

        $this->app->bind(TokenProviderInterface::class, TokenProvider::class);
        $this->app->bind(AccessTokenInterface::class, AccessToken::class);
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
