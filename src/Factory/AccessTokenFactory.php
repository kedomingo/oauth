<?php

namespace KOA2\Factory;

use KOA2\Model\AccessToken;
use KOA2\Repository\Contract\AccessTokenRepositoryInterface;
use KOA2\Repository\Contract\ClientRepositoryInterface;
use KOA2\Repository\Contract\ScopeRepositoryInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;

final class AccessTokenFactory
{
    /**
     * @var AccessTokenRepositoryInterface
     */
    private $accessTokenRepository;

    /**
     * @var ClientRepositoryInterface
     */
    private $clientRepository;

    /**
     * @var ScopeRepositoryInterface
     */
    private $scopeRepository;

    /**
     * AccessTokenFactory constructor.
     *
     * @param AccessTokenRepositoryInterface $accessTokenRepository
     * @param ClientRepositoryInterface      $clientRepository
     * @param ScopeRepositoryInterface       $scopeRepository
     */
    public function __construct(
        AccessTokenRepositoryInterface $accessTokenRepository,
        ClientRepositoryInterface $clientRepository,
        ScopeRepositoryInterface $scopeRepository
    ) {
        $this->accessTokenRepository = $accessTokenRepository;
        $this->clientRepository = $clientRepository;
        $this->scopeRepository = $scopeRepository;
    }

    /**
     * @param string $token
     * @return AccessToken|null
     * @throws \Exception
     */
    public function fromToken(string $token): ?AccessToken
    {
        $accessTokenDto = $this->accessTokenRepository->findByIdentifier($token);
        if ($accessTokenDto === null) {
            return null;
        }

        $clientEntity = $this->clientRepository->getClientEntity($accessTokenDto->getClientId());
        $scopeEntities = array_map(
            function (string $scope): ?ScopeEntityInterface {
                return $this->scopeRepository->getScopeEntityByIdentifier($scope);
            },
            json_decode($accessTokenDto->getScopes(), true)
        );

        $accessToken = new AccessToken($clientEntity, $scopeEntities, $accessTokenDto->getUserId());
        $accessToken->setIdentifier($token);
        $accessToken->setExpiryDateTime(new \DateTimeImmutable($accessTokenDto->getExpiresAt()));

        return $accessToken;
    }
}
