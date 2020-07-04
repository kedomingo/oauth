<?php declare(strict_types=1);

namespace KOA2\PDO;

use PDO;

interface PDOConnectionInterface
{
    /**
     * @return PDO|null
     */
    public function getPDO(): ?PDO;
}