<?php declare(strict_types=1);

namespace KOA2\Model;

use DateTimeImmutable;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;

class RefreshToken implements RefreshTokenEntityInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var AccessTokenEntityInterface
     */
    private $accessToken;

    /**
     * @var bool
     */
    private $isRevoked;

    /**
     * @var DateTimeImmutable
     */
    private $expiresAt;

    /**
     * Get the token's identifier.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->id;
    }

    /**
     * Set the token's identifier.
     *
     * @param mixed $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->id = $identifier;
    }

    /**
     * Get the token's expiry date time.
     *
     * @return DateTimeImmutable
     */
    public function getExpiryDateTime()
    {
        return $this->expiresAt;
    }

    /**
     * Set the date time when the token expires.
     *
     * @param DateTimeImmutable $dateTime
     */
    public function setExpiryDateTime(DateTimeImmutable $dateTime)
    {
        $this->expiresAt = $dateTime;
    }

    /**
     * Set the access token that the refresh token was associated with.
     *
     * @param AccessTokenEntityInterface $accessToken
     */
    public function setAccessToken(AccessTokenEntityInterface $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * Get the access token that the refresh token was originally associated with.
     *
     * @return AccessTokenEntityInterface
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }
}