<?php declare(strict_types=1);

namespace KOA2\PDO;

use PDO;
use PDOException;

final class Connection implements ConnectionInterface
{
    /**
     * @var PDO
     */
    private static $handleSingleton;

    /**
     * @var ConnectionConfigurationProviderInterface
     */
    private $configurationProvider;

    /**
     * Connection constructor.
     *
     * @param ConnectionConfigurationProviderInterface $configurationProvider
     */
    public function __construct(ConnectionConfigurationProviderInterface $configurationProvider)
    {
        $this->configurationProvider = $configurationProvider;
    }

    /**
     * @return PDO|null
     */
    public function getConnection(): ?PDO
    {
        if (static::$handleSingleton !== null) {
            return static::$handleSingleton;
        }

        $host = $this->configurationProvider->getHost() !== null
            ? ';host=' . $this->configurationProvider->getHost()
            : null;

        $port = $this->configurationProvider->getPort() !== null
            ? ';port=' . $this->configurationProvider->getPort()
            : null;

        $dsn = sprintf(
            '%s:dbname=%s%s%s',
            $this->configurationProvider->getDatabaseDriver(),
            $this->configurationProvider->getDatabaseName(),
            ($host ?? ''),
            ($port ?? '')
        );

        $user = $this->configurationProvider->getUsername();
        $password = $this->configurationProvider->getPassword();

        try {
            static::$handleSingleton = new PDO($dsn, $user, $password);
            static::$handleSingleton->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            return null;
        }

        return static::$handleSingleton;
    }
}