<?php declare(strict_types=1);

namespace KOA2\Service;

use Firebase\JWT\JWT;
use KOA2\Model\IssuerContext;
use KOA2\Model\JWTPayload;
use KOA2\Repository\ClientRepository;

class ClientAuthorizer implements ClientAuthorizerInterface
{
    // 5 minutes
    private const DEFAULT_AUTH_CODE_LIFETIME_SECONDS = 300;

    /**
     * @var ClientRepository
     */
    private $clientRepository;

    /**
     * ClientAuthenticator constructor.
     *
     * @param ClientRepository $clientRepository
     */
    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * The user authorizes the client to access on its behalf
     *
     * @param IssuerContext $context
     * @param int $userId
     * @param string $scope
     * @return string
     */
    public function authorizeClient(
        IssuerContext $context,
        int $userId,
        string $scope
    ): string
    {
        $payload = new JWTPayload(
            $context->getUrl(),
            $context->getAudience(),
            time(),
            time() + self::DEFAULT_AUTH_CODE_LIFETIME_SECONDS,
            $context->getClientId(),
            $userId,
            $scope
        );

        return $payload->encode($context->getEncryptionKey());
    }
}