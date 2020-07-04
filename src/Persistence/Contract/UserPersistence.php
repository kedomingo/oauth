<?php declare(strict_types=1);

namespace KOA2\Persistence\Contract;


use KOA2\DTO\UserDTO;
use League\OAuth2\Server\Entities\ClientEntityInterface;

interface UserPersistence
{
    /**
     * Get a user entity.
     *
     * @param string $username
     * @param string $password
     *
     * @return UserDTO|null
     */
    public function findUserByUsernamePassword(
        $username,
        $password
    ): ?UserDTO;
}