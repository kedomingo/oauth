<?php declare(strict_types=1);

namespace KOA2\Repository;

use KOA2\Model\Client;
use KOA2\Persistence\Contract\ClientPersistence;
use KOA2\Repository\Contract\ClientRepositoryInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use Exception;

class ClientRepository implements ClientRepositoryInterface
{
    private const GRANT_TYPE_AUTH_CODE = 'authorization_code';

    private const GRANTS_WITH_PASSWORD_BYPASS = [
        self::GRANT_TYPE_AUTH_CODE,
    ];

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

        return $clientDTO === null ? null : new Client(
            $clientDTO->getClientId(),
            $clientDTO->getName(),
            $clientDTO->getRedirectUrl(),
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
     * @throws Exception
     */
    public function validateClient($clientIdentifier, $clientSecret, $grantType): bool
    {
        if (empty($clientSecret) && !in_array($grantType, self::GRANTS_WITH_PASSWORD_BYPASS, true)) {
            throw new Exception('Client secret not provided for grant type ' . $grantType);
        }

        $clientDTO = $this->clientPersistence->getClient($clientIdentifier);

        return $clientDTO !== null && (
                $clientSecret === $clientDTO->getClientSecret()
                || in_array($grantType, self::GRANTS_WITH_PASSWORD_BYPASS, true)
            );
    }
}