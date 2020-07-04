<?php declare(strict_types=1);

namespace KOA2\Repository;

use KOA2\Model\User;
use KOA2\Persistence\Contract\UserPersistence;
use KOA2\Repository\Contract\UserRepositoryInterface;
use KOA2\Service\Contract\PasswordHasherInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\UserEntityInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @var UserPersistence
     */
    private $userPersistence;

    /**
     * @var PasswordHasherInterface
     */
    private $passwordHasher;

    /**
     * UserRepository constructor.
     * @param UserPersistence         $userPersistence
     * @param PasswordHasherInterface $passwordHasher
     */
    public function __construct(UserPersistence $userPersistence, PasswordHasherInterface $passwordHasher)
    {
        $this->userPersistence = $userPersistence;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * Get a user entity. This is only used by password grant which is only for first-party client apps
     *
     * @param string                $username
     * @param string                $password
     * @param string                $grantType The grant type used
     * @param ClientEntityInterface $clientEntity
     *
     * @return UserEntityInterface|null
     */
    public function getUserEntityByUserCredentials(
        $username,
        $password,
        $grantType,
        ClientEntityInterface $clientEntity
    ): ?UserEntityInterface {
        $userDTO = $this->userPersistence->findUserByUsername($username);
        if ($userDTO === null || $this->passwordHasher->check($password, $userDTO->getPassword())) {
            return null;
        }

        return new User($userDTO->getId());
    }
}