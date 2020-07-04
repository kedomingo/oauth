<?php declare(strict_types=1);

namespace KOA2\Model;

use DateTimeImmutable;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;

class AccessToken implements AccessTokenEntityInterface
{
    /**
     * @var string primary id
     */
    private $token;

    /**
     * @var DateTimeImmutable
     */
    private $expiry;

    /**
     * @var string bigint
     */
    private $userId;

    /**
     * @var ClientEntityInterface
     */
    private $client;

    /**
     * @var ScopeEntityInterface[]
     */
    private $scopes;

    /**
     * @var CryptKey
     */
    private $privateKey;

    /**
     * AccessToken constructor.
     * @param ClientEntityInterface  $client
     * @param ScopeEntityInterface[] $scopes
     * @param string                 $userId bigint
     */
    public function __construct(
        ClientEntityInterface $client,
        array $scopes,
        string $userId = null
    ) {
        $this->client = $client;
        $this->scopes = $scopes;
        $this->userId = $userId;
    }

    /**
     * @param int    $userId
     * @param int    $clientId
     * @param string $scopes
     * @param int    $lifetimeSeconds
     * @param int    $refreshLitetimeSeconds
     * @param string $salt
     * @return self
     */
    private static function generate(
        int $userId,
        int $clientId,
        string $scopes,
        int $lifetimeSeconds,
        int $refreshLitetimeSeconds,
        string $salt
    ): self {
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

    /**
     * Get the token's identifier.
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->token;
    }

    /**
     * Set the token's identifier.
     *
     * @param mixed $token
     *
     * @return void
     */
    public function setIdentifier($token): void
    {
        $this->token = $token;
    }

    /**
     * Get the token's expiry date time.
     *
     * @return DateTimeImmutable
     */
    public function getExpiryDateTime(): DateTimeImmutable
    {
        return $this->expiry;
    }

    /**
     * Set the date time when the token expires.
     *
     * @param DateTimeImmutable $expiry
     *
     * @return void
     */
    public function setExpiryDateTime(DateTimeImmutable $expiry): void
    {
        $this->expiry = $expiry;
    }

    /**
     * Set the identifier of the user associated with the token.
     *
     * @param string|int|null $userId The identifier of the user
     *
     * @return void
     */
    public function setUserIdentifier($userId): void
    {
        $this->userId = $userId;
    }

    /**
     * Get the token user's identifier.
     *
     * @return string|int|null
     */
    public function getUserIdentifier()
    {
        return $this->userId;
    }

    /**
     * Get the client that the token was issued to.
     *
     * @return ClientEntityInterface
     */
    public function getClient(): ClientEntityInterface
    {
        return $this->client;
    }

    /**
     * Set the client that the token was issued to.
     *
     * @param ClientEntityInterface $client
     *
     * @return void
     */
    public function setClient(ClientEntityInterface $client): void
    {
        $this->client = $client;
    }

    /**
     * Associate a scope with the token.
     *
     * @param ScopeEntityInterface $scope
     *
     * @return void
     */
    public function addScope(ScopeEntityInterface $scope): void
    {
        $this->scopes[$scope->getIdentifier()] = $scope;
    }

    /**
     * Return an array of scopes associated with the token.
     *
     * @return ScopeEntityInterface[]
     */
    public function getScopes(): array
    {
        return $this->scopes;
    }

    /**
     * Set a private key used to encrypt the access token.
     *
     * @param CryptKey $privateKey
     *
     * @return void
     */
    public function setPrivateKey(CryptKey $privateKey): void
    {
        $this->privateKey = $privateKey;
    }

    /**
     * Generate a string representation of the access token.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->getIdentifier();
    }

    /**
     * @return string
     */
    public function getClientAsString(): string
    {
        return $this->client->getIdentifier();
    }

    /**
     * Return an array of scopes associated with the token.
     *
     * @return string
     */
    public function getScopesAsString(): string
    {
        $scopes = array_map(
            function (ScopeEntityInterface $scope): string {
                return $scope->getIdentifier();
            },
            $this->getScopes()
        );

        return json_encode($scopes);
    }
}