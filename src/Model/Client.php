<?php declare(strict_types=1);

namespace KOA2\Model;

use League\OAuth2\Server\Entities\ClientEntityInterface;

final class Client implements ClientEntityInterface
{
    /**
     * @var string bigint
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $redirectUri;

    /**
     * @var bool
     */
    private $isConfidential;

    /**
     * Client constructor.
     * @param string $id
     * @param string $name
     * @param string $redirectUri
     * @param bool   $isConfidential
     */
    public function __construct(string $id, string $name, string $redirectUri, bool $isConfidential)
    {
        $this->id = $id;
        $this->name = $name;
        $this->redirectUri = $redirectUri;
        $this->isConfidential = $isConfidential;
    }

    /**
     * Get the client's identifier.
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->id;
    }

    /**
     * Get the client's name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns the registered redirect URI (as a string).
     *
     * Alternatively return an indexed array of redirect URIs.
     *
     * @return string|string[]
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * Returns true if the client is confidential.
     *
     * @return bool
     */
    public function isConfidential(): bool
    {
        return $this->isConfidential;
    }
}