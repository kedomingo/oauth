<?php declare(strict_types=1);

namespace KOA2\Persistence\DB;

use Exception;
use KOA2\DTO\ClientDTO;
use KOA2\PDO\PDOConnection;
use KOA2\Persistence\Contract\ClientPersistence;
use PDO;

final class Client implements ClientPersistence
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
     * Get a client.
     *
     * @param string|int $clientIdentifier The client's identifier
     *
     * @return ClientDTO|null
     * @throws Exception
     */
    public function getClient($clientIdentifier): ?ClientDTO
    {
        $sql = '
            SELECT client_id AS clientId,
                   client_secret AS clientSecret,
                   name,
                   redirect AS redirectUrl,
                   personal_access_client AS isConfidential
              FROM oauth_clients 
             WHERE client_id = :clientId
         ';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':clientId', $clientIdentifier);
        if (!$statement->execute()) {
            throw new Exception('PDO execution failed');
        }

        return $statement->fetchObject(ClientDTO::class) ?: null;
    }
}