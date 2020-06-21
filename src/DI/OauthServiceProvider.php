<?php

namespace KOA2\DI;

use Illuminate\Support\ServiceProvider;
use KOA2\Persistence\Client;
use KOA2\Persistence\ClientInterface;
use KOA2\Repository\ClientRepository;
use KOA2\Repository\ClientRepositoryInterface;
use KOA2\Service\ClientAuthenticator;
use KOA2\Service\ClientAuthenticatorInterface;

class OauthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      $this->app->bind(ClientAuthenticatorInterface::class, ClientAuthenticator::class);
      $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
      $this->app->bind(ClientInterface::class,  Client::class);

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
