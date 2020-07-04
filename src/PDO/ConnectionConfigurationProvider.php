<?php declare(strict_types=1);

namespace KOA2\PDO;

use PDO;

final class ConnectionConfigurationProvider implements ConnectionConfigurationProviderInterface
{
    /**
     * @return string|null
     */
    public function getDatabaseDriver(): ?string
    {
        return getenv('DB_CONNECTION') !== false ? getenv('DB_CONNECTION') : null;
    }

    /**
     * @return string|null
     */
    public function getHost(): ?string
    {
        return getenv('DB_HOST') !== false ? getenv('DB_HOST') : null;
    }

    /**
     * @return string|null
     */
    public function getPort(): ?string
    {
        return getenv('DB_PORT') !== false ? getenv('DB_PORT') : null;
    }

    /**
     * @return string|null
     */
    public function getDatabaseName(): ?string
    {
        return getenv('DB_DATABASE') !== false ? getenv('DB_DATABASE') : null;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return getenv('DB_USERNAME') !== false ? getenv('DB_USERNAME') : null;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : null;
    }
}