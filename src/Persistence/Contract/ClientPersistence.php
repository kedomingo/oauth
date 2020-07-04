<?php declare(strict_types=1);

namespace KOA2\Persistence\Contract;


use KOA2\DTO\ClientDTO;

interface ClientPersistence
{
    /**
     * Get a client.
     *
     * @param string|int $clientIdentifier The client's identifier
     *
     * @return ClientDTO|null
     */
    public function getClient($clientIdentifier): ?ClientDTO;

    /**
     * Validate a client's secret.
     *
     * @param string      $clientIdentifier The client's identifier
     * @param null|string $clientSecret     The client's secret (if sent)
     * @param null|string $grantType        The type of grant the client is using (if sent)
     *
     * @return bool
     */
    public function validateClient(string $clientIdentifier, ?string $clientSecret, ?string $grantType): bool;
}