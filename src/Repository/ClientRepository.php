<?php declare(strict_types=1);

namespace KOA2\Repository;

use KOA2\Model\Client;
use KOA2\Persistence\ClientInterface;

class ClientRepository implements ClientRepositoryInterface {

  /**
   * @var ClientInterface
   */
  private $clientPersistence;

  /**
   * ClientRepository constructor.
   *
   * @param ClientInterface $clientPersistence
   */
  public function __construct(ClientInterface $clientPersistence) {
    $this->clientPersistence = $clientPersistence;
  }


  /**
   * @param int    $clientId
   * @param string $secret
   *
   * @return Client|null
   */
  public function findClient(int $clientId, string $secret) : ?Client {
    $clientDTO = $this->clientPersistence->findClient($clientId, $secret);

    if ($clientDTO === null) {
      return null;
    }

    return new Client($clientDTO->getClientId(), $clientDTO->getClientSecret());
  }
}