<?php declare(strict_types=1);

namespace KOA2\Repository;

use KOA2\Model\Client;

interface ClientRepositoryInterface
{
    public function findClient(int $clientId, string $secret): ?Client;
}