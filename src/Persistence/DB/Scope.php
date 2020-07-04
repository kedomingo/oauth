<?php declare(strict_types=1);

namespace KOA2\Persistence\DB;

use Exception;
use KOA2\DTO\ScopeDTO;
use KOA2\PDO\PDOConnection;
use KOA2\Persistence\Contract\ScopePersistence;
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
     * @param PDOConnection $connection
     */
    public function __construct(PDOConnection $connection)
    {
        $this->pdo = $connection->getPDO();
    }

    /**
     * Return information about a scope.
     *
     * @param $scopeName
     * @return ScopeDTO|null
     * @throws Exception
     */
    public function findScopeByName($scopeName): ?ScopeDTO
    {
        $sql = '
            SELECT id,
                   name 
              FROM oauth_scopes 
             WHERE name = :scopeName
         ';
        $statement = $this->query($this->pdo, $sql, ['scopeName' => $scopeName]);

        return $statement->fetchObject(ScopeDTO::class) ?: null;
    }

    /**
     * Return information about a scope.
     *
     * @param array $names
     *
     * @return ScopeDTO[]
     * @throws Exception
     */
    public function findScopesByNames(array $names): array
    {
        if (empty($names)) {
            return [];
        }

        $sql = '
            SELECT id,
                   name 
              FROM oauth_scopes 
             WHERE name IN (:names)
         ';
        $statement = $this->query($this->pdo, $sql, ['names' => $names]);

        return $statement->fetchAll(PDO::FETCH_CLASS, ScopeDTO::class);
    }
}