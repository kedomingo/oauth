<?php declare(strict_types=1);

namespace KOA2\DTO;

class AccessTokenDTO
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var int|null
     */
    private $user_id;

    /**
     * @var int
     */
    private $client_id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $scopes;

    /**
     * @var string
     */
    private $expires_at;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->user_id === null ? null : (int)$this->user_id;
    }

    /**
     * @return int
     */
    public function getClientId(): int
    {
        return (int)$this->client_id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getScopes(): string
    {
        return $this->scopes;
    }

    /**
     * @return string
     */
    public function getExpiresAt(): string
    {
        return $this->expires_at;
    }
}
