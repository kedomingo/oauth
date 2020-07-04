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
}