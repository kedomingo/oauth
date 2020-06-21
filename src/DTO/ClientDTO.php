<?php

namespace KOA2\DTO;

class ClientDTO {

  private $clientId;
  private $clientSecret;

  /**
   * @return mixed
   */
  public function getClientId() {
    return $this->clientId;
  }

  /**
   * @return mixed
   */
  public function getClientSecret() {
    return $this->clientSecret;
  }

}