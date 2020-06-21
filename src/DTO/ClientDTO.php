<?php

namespace KOA2\DTO;

class ClientDTO
{
    /**
     * @var int|string
     */
    private $clientId;

    /**
     * @var string
     */
    private $clientSecret;

    /**
     * @return int|string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }
}