<?php declare(strict_types=1);

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
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $redirectUrl;

    /**
     * @var bool
     */
    private $isConfidential;

    /**
     * ClientDTO constructor.
     */
    private function __construct()
    {
        $this->isConfidential = (bool)$this->isConfidential;
    }

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

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isConfidential(): bool
    {
        return $this->isConfidential;
    }

    /**
     * @return string
     */
    public function getRedirectUrl(): string
    {
        return $this->redirectUrl;
    }
}