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
    public function findScopeById($identifier): ?ScopeDTO;

    /**
     * Given a client, grant type and optional user identifier validate the set of scopes requested are valid and optionally
     * append additional scopes or remove requested scopes.
     *
     * @param ScopeEntityInterface[] $scopes
     * @param string                 $grantType
     * @param ClientEntityInterface  $clientEntity
     * @param null|string            $userIdentifier
     *
     * @return ScopeEntityInterface[]
     */
    public function finalizeScopes(
        array $scopes,
        $grantType,
        ClientEntityInterface $clientEntity,
        $userIdentifier = null
    ): array;
}