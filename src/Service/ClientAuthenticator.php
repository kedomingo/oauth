<?php declare(strict_types=1);

namespace KOA2\Service;

use KOA2\Repository\ClientRepository;

class ClientAuthenticator implements ClientAuthenticatorInterface {

  /**
   * @var ClientRepository
   */
  private $clientRepository;

  /**
   * ClientAuthenticator constructor.
   *
   * @param ClientRepository $clientRepository
   */
  public function __construct(ClientRepository $clientRepository) {
    $this->clientRepository = $clientRepository;
  }

  public function authenticateClient(int $clientId, string $clientSecret) : bool {

    $client = $this->clientRepository->findClient($clientId, $clientSecret);

    return !empty($client);

  }

}