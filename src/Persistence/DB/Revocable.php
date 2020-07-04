<?php declare(strict_types=1);

namespace KOA2\Persistence\DB;

use Exception;
use PDO;

trait Revocable
{
    // Requires trait QueriesPDO;

    /**
     * Revoke the refresh token.
     *
     * @param PDO    $pdo
     * @param string $tableName
     * @param string $id
     *
     * @param string $idColumn
     * @return void
     */
    public function revoke(PDO $pdo, string $tableName, $id, string $idColumn = 'id'): void
    {
        $sanitizedTable = preg_replace('/[^\w_]/', '', $tableName);
        $sanitizedIdColumn = preg_replace('/[^\w_]/', '', $idColumn);

        $sql = '
            UPDATE ' . $sanitizedTable . '
               SET revoked = :revoked
             WHERE ' . $sanitizedIdColumn . ' = :id
         ';

        $this->query(
            $pdo,
            $sql,
            [
                'revoked' => 1,
                'id'      => $id
            ]
        );
    }

    /**
     * Check if the refresh token has been revoked.
     *
     * @param PDO    $pdo
     * @param string $tableName
     * @param string $id
     *
     * @return bool Return true if this token has been revoked
     * @throws Exception
     */
    public function isRevoked(PDO $pdo, string $tableName, $id): bool
    {
        $sanitizedTable = preg_replace('/[^\w_]/', '', $tableName);

        $sql = '
            SELECT revoked
              FROM ' . $sanitizedTable . '
             WHERE id = :id
         ';

        $statement = $this->query($pdo, $sql, ['id' => $id]);

        return (bool)$statement->fetchColumn();
    }
}