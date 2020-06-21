<?php declare(strict_types=1);

namespace KOA2\Persistence;

use KOA2\DTO\ClientDTO;
use KOA2\Exceptions\DTOHydrationException;
use KOA2\Schema\ClientSchema;
use DB;

final class Client implements ClientInterface {

  use HydratesDTOTrait;

  /**
   * @param int    $clientId
   * @param string $secret
   *
   * @return ClientDTO
   * @throws DTOHydrationException
   */
  public function findClient(int $clientId, string $secret) : ?ClientDTO {

    $result = DB::table(ClientSchema::getTablename())
        ->where(ClientSchema::clientId(), '=', $clientId)
        ->where(ClientSchema::clientSecret(), '=', $secret)
        ->first();

    return $result === null ? null : $this->hydrateOne(ClientDTO::class, $result);
  }
}