<?php declare(strict_types=1);

namespace KOA2\Persistence\DB;

use Exception;
use KOA2\DTO\UserDTO;
use KOA2\PDO\Connection;
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
     * @var PasswordHasherInterface
     */
    private $passwordHasher;

    /**
     * Client constructor.
     * @param Connection              $connection
     * @param PasswordHasherInterface $passwordHasher
     */
    public function __construct(
        Connection $connection,
        PasswordHasherInterface $passwordHasher
    ) {
        $this->pdo = $connection->getConnection();
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * Get a user entity.
     *
     * @param string $username
     * @param string $password
     * @return UserDTO|null
     * @throws Exception
     */
    public function findUserByUsernamePassword(
        $username,
        $password
    ): ?UserDTO {
        $sql = '
            SELECT id,
                   username,
                   password
              FROM users 
             WHERE username = :username
         ';

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':username', $username);
        if (!$statement->execute()) {
            throw new Exception('PDO execution failed');
        }
        $user = $statement->fetchObject(UserDTO::class);

        return $user !== null && $this->passwordHasher->check($password, $user->getPassword()) ? $user : null;
    }
}