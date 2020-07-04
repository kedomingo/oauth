<?php declare(strict_types=1);

namespace KOA2\Persistence\DB;

use Exception;
use KOA2\DTO\ClientDTO;
use KOA2\PDO\Connection;
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
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->pdo = $connection->getConnection();
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
                   personal_access_client AS isConfidential
              FROM oauth_clients 
             WHERE client_id = :clientId
         ';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':clientId', $clientIdentifier);
        if (!$statement->execute()) {
            throw new Exception('PDO execution failed');
        }

        return $statement->fetchObject(ClientDTO::class);
    }

    /**
     * Validate a client's secret.
     *
     * @param string      $clientIdentifier The client's identifier
     * @param null|string $clientSecret     The client's secret (if sent)
     * @param null|string $grantType        The type of grant the client is using (if sent)
     *
     * @return bool
     */
    public function validateClient(string $clientIdentifier, ?string $clientSecret, ?string $grantType): bool
    {
        // TODO
        return true;
    }
}