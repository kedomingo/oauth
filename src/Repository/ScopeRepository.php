<?php declare(strict_types=1);

namespace KOA2\Repository;

use KOA2\DTO\ScopeDTO;
use KOA2\Model\Scope;
use KOA2\Persistence\Contract\ScopePersistence;
use KOA2\Repository\Contract\ScopeRepositoryInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;

class ScopeRepository implements ScopeRepositoryInterface
{
    /**
     * @var ScopePersistence
     */
    private $scopePersistence;

    /**
     * ScopeRepository constructor.
     * @param ScopePersistence $scopePersistence
     */
    public function __construct(ScopePersistence $scopePersistence)
    {
        $this->scopePersistence = $scopePersistence;
    }

    /**
     * Return information about a scope.
     *
     * @param $identifierOrScope
     * @return ScopeEntityInterface|null
     */
    public function getScopeEntityByIdentifier($identifierOrScope): ?ScopeEntityInterface
    {
        $scopeDTO = $this->scopePersistence->findScopeByName($identifierOrScope);

        if ($scopeDTO === null) {
            return null;
        }

        return new Scope($scopeDTO->getId(), $scopeDTO->getName());
    }

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
    ): array {
        // TODO: the enhancement specified in the doc is not implemented here
        return $scopes;
    }
}