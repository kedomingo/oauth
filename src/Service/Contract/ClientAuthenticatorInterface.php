<?php declare(strict_types=1);

namespace KOA2\Service\Contract;

interface ClientAuthenticatorInterface
{
    /**
     * @param int $clientId
     * @param string $clientSecret
     *
     * @return bool
     */
    public function authenticateClient(int $clientId, string $clientSecret): bool;
}