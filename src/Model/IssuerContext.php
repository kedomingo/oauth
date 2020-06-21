<?php declare(strict_types=1);

namespace KOA2\Model;

final class IssuerContext
{
    private const DEFAULT_AUTHORIZATION_VALIDITY_SECONDS = 300;

    /**
     * @var int
     */
    private $clientId;

    /**
     * @var string
     */
    private $encryptionKey;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $audience;

    /**
     * @var string
     */
    private $authorizationCodeValidity;

    /**
     * IssuerContext constructor.
     * @param int $clientId
     * @param string $encryptionKey
     * @param string $url
     * @param string $audience
     * @param int $authorizationCodeValidity
     */
    public function __construct(
        int $clientId,
        string $encryptionKey,
        string $url,
        string $audience,
        int $authorizationCodeValidity = self::DEFAULT_AUTHORIZATION_VALIDITY_SECONDS
    )
    {
        $this->clientId = $clientId;
        $this->encryptionKey = $encryptionKey;
        $this->url = $url;
        $this->audience = $audience;
        $this->authorizationCodeValidity = $authorizationCodeValidity;
    }

    /**
     * @return string
     */
    public function getEncryptionKey(): string
    {
        return $this->encryptionKey;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getAudience(): string
    {
        return $this->audience;
    }

    /**
     * @return string
     */
    public function getAuthorizationCodeValidity(): string
    {
        return $this->authorizationCodeValidity;
    }

    /**
     * @return int
     */
    public function getClientId(): int
    {
        return $this->clientId;
    }
}