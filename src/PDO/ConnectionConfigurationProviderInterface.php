<?php declare(strict_types=1);

namespace KOA2\PDO;

use PDO;

interface ConnectionConfigurationProviderInterface
{
    /**
     * @return string|null
     */
    public function getDatabaseDriver(): ?string;

    /**
     * @return string|null
     */
    public function getHost(): ?string;

    /**
     * @return string|null
     */
    public function getPort(): ?string;

    /**
     * @return string|null
     */
    public function getDatabaseName(): ?string;

    /**
     * @return string|null
     */
    public function getUsername(): ?string;

    /**
     * @return string|null
     */
    public function getPassword(): ?string;
}