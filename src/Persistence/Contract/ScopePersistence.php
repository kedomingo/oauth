<?php declare(strict_types=1);

namespace KOA2\Persistence\Contract;

use KOA2\DTO\ScopeDTO;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;

interface ScopePersistence
{
    /**
     * Return information about a scope.
     *
     * @param string|int $identifier The scope identifier
     *
     * @return ScopeDTO|null
     */
    public function findScopeByName($identifier): ?ScopeDTO;

    /**
     * Return information about a scope.
     *
     * @param array $names
     *
     * @return ScopeDTO[]
     */
    public function findScopesByNames(array $names): array;
}