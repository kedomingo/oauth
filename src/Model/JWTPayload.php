<?php declare(strict_types=1);

namespace KOA2\Model;

use Firebase\JWT\JWT;

final class JWTPayload
{
    private const ALG = 'HS256';

    /**
     * @var string
     */
    private $issuer;

    /**
     * @var string
     */
    private $audience;

    /**
     * @var int
     */
    private $issuedAt;

    /**
     * @var int
     */
    private $expiry;

    /**
     * @var int
     */
    private $clientId;

    /**
     * @var int
     */
    private $userId;

    /**
     * @var string
     */
    private $scope;

    /**
     * JWTPayload constructor.
     * @param string $issuer
     * @param string $audience
     * @param int $issuedAt
     * @param int $expiry
     * @param int $clientId
     * @param int $userId
     * @param string $scope
     */
    public function __construct(string $issuer, string $audience, int $issuedAt, int $expiry, int $clientId, int $userId, string $scope)
    {
        $this->issuer = $issuer;
        $this->audience = $audience;
        $this->issuedAt = $issuedAt;
        $this->expiry = $expiry;
        $this->clientId = $clientId;
        $this->userId = $userId;
        $this->scope = $scope;
    }

    /**
     * @param string $token
     * @param string $encKey
     * @return JWTPayload|null
     */
    public static function fromJWT(string $token, string $encKey): ?self
    {
        try {
            $obj = JWT::decode($token, $encKey, [self::ALG]);
        } catch (\Exception $e) {
            return null;
        }

        return new static (
            $obj->iss,
            $obj->aud,
            $obj->iat,
            $obj->exp,
            $obj->client_id,
            $obj->user_id,
            $obj->scope,
        );
    }

    /**
     * @param string $encryptionKey
     * @return string
     */
    public function encode(string $encryptionKey): string
    {
        $payload = array(
            'iss' => $this->getIssuer(),
            'aud' => $this->getAudience(),
            'iat' => $this->getIssuedAt(),
            'exp' => $this->getExpiry(),
            'client_id' => $this->getClientId(),
            'user_id' => $this->getUserId(),
            'scope' => $this->getScope()
        );

        return JWT::encode($payload, $encryptionKey, self::ALG);
    }

    /**
     * @return string
     */
    public function getIssuer(): string
    {
        return $this->issuer;
    }

    /**
     * @return string
     */
    public function getAudience(): string
    {
        return $this->audience;
    }

    /**
     * @return int
     */
    public function getIssuedAt(): int
    {
        return $this->issuedAt;
    }

    /**
     * @return int
     */
    public function getExpiry(): int
    {
        return $this->expiry;
    }

    /**
     * @return int
     */
    public function getClientId(): int
    {
        return $this->clientId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getScope(): string
    {
        return $this->scope;
    }
}