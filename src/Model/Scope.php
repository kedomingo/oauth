<?php declare(strict_types=1);

namespace KOA2\Model;

use DateTimeImmutable;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use KOA2\Repository\Contract\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\CryptKey;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;

class Scope implements ScopeEntityInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * Scope constructor.
     * @param int    $id
     * @param string $name
     */
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * Get the scope's identifier.
     *
     * @return string|int
     */
    public function getIdentifier(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function jsonSerialize(): string
    {
        return $this->name;
    }
}