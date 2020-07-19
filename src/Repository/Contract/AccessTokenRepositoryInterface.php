<?php declare(strict_types=1);

namespace KOA2\Repository\Contract;

use KOA2\DTO\AccessTokenDTO;
use KOA2\Model\AccessToken;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface as BaseAccessTokenRepositoryInterface;

interface AccessTokenRepositoryInterface extends BaseAccessTokenRepositoryInterface
{
    public function findByIdentifier(string $id): ?AccessTokenDTO;
}
