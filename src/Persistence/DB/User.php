<?php declare(strict_types=1);

namespace KOA2\Persistence\DB;

use Exception;
use KOA2\DTO\UserDTO;
use KOA2\PDO\PDOConnection;
use KOA2\Persistence\Contract\UserPersistence;
use KOA2\Service\Contract\PasswordHasherInterface;
use PDO;

final class User implements UserPersistence
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
     * Get a user entity.
     *
     * @param string $username
     * @param string $password
     * @return UserDTO|null
     * @throws Exception
     */
    public function findUserByUsername(
        $username
    ): ?UserDTO {
        $sql = '
            SELECT id,
                   username,
                   password
              FROM users 
             WHERE username = :username
         ';
        $statement = $this->query($this->pdo, $sql, ['username' => $username]);

        return $statement->fetchObject(UserDTO::class) ?: null;
    }
}