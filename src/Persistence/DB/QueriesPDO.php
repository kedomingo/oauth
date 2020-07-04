<?php declare(strict_types=1);

namespace KOA2\Persistence\DB;

use Exception;
use PDO;
use PDOStatement;

/**
 * @author    Kyle Domingo <kdomingo@wayfair.com>
 * @copyright 2020 Wayfair LLC - All rights reserved
 */
trait QueriesPDO
{
    /**
     * @param PDO    $pdo
     * @param string $sql
     * @param array  $params
     * @return PDOStatement
     * @throws Exception
     */
    private function query(PDO $pdo, string $sql, array $params): PDOStatement
    {
        $statement = $pdo->prepare($sql);

        if (preg_match_all('/(?::([\w_]+))/', $sql, $binds)) {
            foreach ($binds[1] as $bind) {
                if (!array_key_exists($bind, $params)) {
                    throw new Exception('Could not find the value for bind :' . $bind . ' in the given parameters');
                }
                $value = $params[$bind];
                $type = $this->getBindParamType($value);
                $statement->bindValue(':' . $bind, $value, $type);
            }
        }
        $statement->execute();

        return $statement;
    }

    /**
     * @param mixed $value
     *
     * @return int
     */
    private function getBindParamType($value): int
    {
        if ($value === null) {
            return PDO::PARAM_NULL;
        }
        if ($value === true || $value === false) {
            return PDO::PARAM_BOOL;
        }
        $MAX_UNSIGNED_INT = 4294967295;
        if (is_numeric($value) && $value > $MAX_UNSIGNED_INT) {
            return PDO::PARAM_STR;
        }
        if (is_numeric($value)) {
            return PDO::PARAM_INT;
        }
        return PDO::PARAM_STR;
    }

    /**
     * @param string $errorMessage
     *
     * @return bool
     */
    private function isDuplicateError(string $errorMessage): bool
    {
        $DUPLICATE_AUTH_CODE_PATTERN = '/Integrity constraint violation.*Duplicate entry/i';

        return (bool)preg_match($DUPLICATE_AUTH_CODE_PATTERN, $errorMessage);
    }
}