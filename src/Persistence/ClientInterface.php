<?php declare(strict_types=1);
/**
 * @author    Kyle Domingo <kdomingo@wayfair.com>
 * @copyright 2020 Wayfair LLC - All rights reserved
 */

namespace KOA2\Persistence;

use KOA2\DTO\ClientDTO;

interface ClientInterface {
  /**
   * @param int    $clientId
   *
   * @param string $secret
   *
   * @return ClientDTO|null
   */
  public function findClient(int $clientId, string $secret) : ?ClientDTO;
}