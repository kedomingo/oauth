<?php declare(strict_types=1);

namespace KOA2\Repository;

use KOA2\Model\Client;
use KOA2\Persistence\Contract\ClientPersistence;
use KOA2\Repository\Contract\ClientRepositoryInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;

class ClientRepository implements ClientRepositoryInterface
{
    /**
     * @var ClientPersistence
     */
    private $clientPersistence;

    /**
     * ClientRepository constructor.
     * @param ClientPersistence $clientPersistence
     */
    public function __construct(ClientPersistence $clientPersistence)
    {
        $this->clientPersistence = $clientPersistence;
    }

    /**
     * Get a client.
     *
     * @param string $clientIdentifier The client's identifier
     *
     * @return ClientEntityInterface|null
     */
    public function getClientEntity($clientIdentifier): ?ClientEntityInterface
    {
        $clientDTO = $this->clientPersistence->getClient($clientIdentifier);

        // TODO
        return $clientDTO === null ? null : new Client(
            $clientDTO->getClientId(),
            $clientDTO->getName(),
            '',
            $clientDTO->isConfidential()
        );
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
    public function validateClient($clientIdentifier, $clientSecret, $grantType): bool
    {
        return $this->clientPersistence->validateClient(
            $clientIdentifier,
            $clientSecret,
            $grantType
        );
    }
}