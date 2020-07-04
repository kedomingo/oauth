<?php declare(strict_types=1);

namespace KOA2\Model;

use DateTimeImmutable;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use KOA2\Repository\Contract\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\CryptKey;

use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;

class AuthCode implements AuthCodeEntityInterface
{
    /**
     * @var string auth code
     */
    private $id;

    /**
     * @var string bigint
     */
    private $userId;

    /**
     * @var string
     */
    private $redirectUri;

    /**
     * @var ClientEntityInterface
     */
    private $client;

    /**
     * @var ScopeEntityInterface[]
     */
    private $scopes;

    /**
     * @var DateTimeImmutable
     */
    private $expiry;

//    /**
//     * AuthCode constructor.
//     * @param string                 $id
//     * @param string                 $userId
//     * @param string                 $redirectUri
//     * @param ClientEntityInterface  $client
//     * @param ScopeEntityInterface[] $scopes
//     * @param DateTimeImmutable      $expiry
//     */
//    public function __construct(
//        string $id,
//        string $userId,
//        string $redirectUri,
//        ClientEntityInterface $client,
//        array $scopes,
//        DateTimeImmutable $expiry
//    ) {
//        $this->id = $id;
//        $this->userId = $userId;
//        $this->redirectUri = $redirectUri;
//        $this->client = $client;
//        $this->scopes = $scopes;
//        $this->expiry = $expiry;
//    }

    /**
     * @return string|null
     */
    public function getRedirectUri(): ?string
    {
        return $this->redirectUri;
    }

    /**
     * @param string $uri
     *
     * @return void
     */
    public function setRedirectUri($uri): void
    {
        $this->redirectUri = $uri;
    }

    /**
     * Get the token's identifier.
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->id;
    }

    /**
     * Set the token's identifier.
     *
     * @param mixed $authCodeId
     *
     * @return void
     */
    public function setIdentifier($authCodeId): void
    {
        $this->id = $authCodeId;
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