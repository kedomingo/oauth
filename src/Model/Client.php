<?php declare(strict_types=1);

namespace KOA2\Model;

final class Client
{
    /**
     * @var int
     */
    private $clientId;

    /**
     * @var string
     */
    private $clientSecret;

    /**
     * Client constructor.
     *
     * @param int $clientId
     * @param string $clientSecret
     */
    public function __construct(int $clientId, string $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * @return int
     */
    public function getClientId(): int
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