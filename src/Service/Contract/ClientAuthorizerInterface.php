<?php declare(strict_types=1);

namespace KOA2\Service\Contract;

use KOA2\Model\IssuerContext;

interface ClientAuthorizerInterface
{
    /**
     * @param IssuerContext $context
     * @param int $userId
     * @param string $scope
     * @return string
     */
    public function authorizeClient(
        IssuerContext $context,
        int $userId,
        string $scope
    ): string;
}