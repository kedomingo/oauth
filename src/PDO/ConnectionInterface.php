<?php declare(strict_types=1);

namespace KOA2\PDO;

use PDO;

interface ConnectionInterface
{
    /**
     * @return PDO|null
     */
    public function getConnection(): ?PDO;
}