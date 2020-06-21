<?php

namespace KOA2\Model;

class Token
{
    /**
     * Token id
     * @var string
     */
    private $id;

    /**
     * Refresh Token
     * @var string
     */
    private $refreshToken;

    /**
     * @var int
     */
    private $userId;

    /**
     * @var int
     */
    private $clientId;

    /**
     * @var string
     */
    private $scopes;

    /**
     * @var string
     */
    private $expiresAt;

    /**
     * @var string
     */
    private $refreshExpiresAt;

    /**
     * Token constructor.
     * @param string $id
     * @param string|null $refreshToken
     * @param int $userId
     * @param int $clientId
     * @param string $scopes
     * @param string|null $expiresAt
     */
    public function __construct(string $id, ?string $refreshToken, int $userId, int $clientId, string $scopes, string $expiresAt, ?string $refreshExpiresAt)
    {
        $this->id = $id;
        $this->refreshToken = $refreshToken;
        $this->userId = $userId;
        $this->clientId = $clientId;
        $this->scopes = $scopes;
        $this->expiresAt = $expiresAt;
        $this->refreshExpiresAt = $refreshExpiresAt;
    }

    /**
     * @return string|null
     */
    public function getRefreshExpiresAt(): ?string
    {
        return $this->refreshExpiresAt;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
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
    public function getScopes(): string
    {
        return $this->scopes;
    }

    /**
     * @return string
     */
    public function getExpiresAt(): string
    {
        return $this->expiresAt;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return strtotime($this->expiresAt) > time();
    }

    /**
     * @param int $userId
     * @param int $clientId
     * @param string $scopes
     * @param int $lifetimeSeconds
     * @param int $refreshLitetimeSeconds
     * @param string $salt
     * @return self
     */
    public static function generate(
        int $userId, int $clientId, string $scopes, int $lifetimeSeconds, int $refreshLitetimeSeconds, string $salt
    ): self
    {
        $token = sha1(implode('.', [$userId, $clientId, $scopes, $salt, time()]));
        $refreshToken = sha1(implode('.', [$userId, $clientId, $scopes, $salt, time(), 'refresh']));

        return new self(
            $token,
            $refreshToken,
            $userId,
            $clientId,
            $scopes,
            date('Y-m-d H:i:s', time() + $lifetimeSeconds),
            date('Y-m-d H:i:s', time() + $refreshLitetimeSeconds)
        );
    }
}