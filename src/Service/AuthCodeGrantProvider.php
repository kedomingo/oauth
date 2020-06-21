<?php declare(strict_types=1);

namespace KOA2\Service;

use KOA2\Exception\GrantException;
use KOA2\Model\JWTPayload;
use KOA2\Model\Token;

final class AuthCodeGrantProvider extends AbstractGrantProvider
{
    /**
     * @var TokenProviderInterface
     */
    private $tokenProvider;

    /**
     * @var EncryptionKeyProviderInterface
     */
    private $encryptionKeyProvider;

    /**
     * AuthCodeGrantProvider constructor.
     * @param EncryptionKeyProviderInterface $encryptionKeyProvider
     * @param TokenProviderInterface $tokenProvider
     */
    public function __construct(
        EncryptionKeyProviderInterface $encryptionKeyProvider,
        TokenProviderInterface $tokenProvider
    )
    {
        $this->encryptionKeyProvider = $encryptionKeyProvider;
        $this->tokenProvider = $tokenProvider;
    }

    /**
     * Issue a token based on the given parameters. The parameters are required to have the authorization code and
     * the issued token lifetime in seconds. Tokens  that are beyond its lifetime is invalid.
     * Also required is the lifetime of the refresh token
     *
     * @param array $parameters
     * @return Token
     * @throws GrantException
     */
    public function grantToken(array $parameters): Token
    {
        if (!isset($parameters['code'])) {
            throw new GrantException('Missing required parameter: code');
        }
        if (!isset($parameters['lifetime'])) {
            throw new GrantException('Missing required parameter: lifetime');
        }
        if (!isset($parameters['refresh_lifetime'])) {
            throw new GrantException('Missing required parameter: refresh_lifetime');
        }

        $encryptionKey = $this->encryptionKeyProvider->getEncryptionKey();

        $payload = JWTPayload::fromJWT($parameters['code'], $encryptionKey);
        if (empty($payload)) {
            throw new GrantException('Failed to decode given authorization code');
        }

        $token = Token::generate(
            $payload->getUserId(),
            $payload->getClientId(),
            $payload->getScope(),
            $parameters['lifetime'],
            $parameters['refresh_lifetime'],
            $encryptionKey
        );

        $this->tokenProvider->issueToken($token);

        return $token;
    }
}