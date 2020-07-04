<?php declare(strict_types=1);

namespace KOA2\Persistence\DB;

use Exception;
use KOA2\DTO\ScopeDTO;
use KOA2\DTO\UserDTO;
use KOA2\PDO\Connection;
use KOA2\Persistence\Contract\ScopePersistence;
use KOA2\Persistence\Contract\UserPersistence;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use PDO;

final class Scope implements ScopePersistence
{
    use QueriesPDO;

    /**
     * @var PDO
     */
    private $pdo;

    /**
     * Client constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->pdo = $connection->getConnection();
    }

    /**
     * Return information about a scope.
     *
     * @param $scopeId
     * @return ScopeDTO|null
     * @throws Exception
     */
    public function findScopeById($scopeId): ?ScopeDTO
    {
        $sql = '
            SELECT id,
                   name 
              FROM oauth_scopes 
             WHERE id = :scopeId
         ';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':scopeId', $scopeId);
        if (!$statement->execute()) {
            throw new Exception('PDO execution failed');
        }

        return $statement->fetchObject(ScopeDTO::class);
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
    }
}