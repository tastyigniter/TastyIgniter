<?php

declare(strict_types=1);

namespace Igniter\Flame\Database\Connectors;

use Closure;
use Igniter\Flame\Database\Connections\MySqlConnection;
use Illuminate\Database\Connection;
use Illuminate\Database\Connectors\ConnectionFactory as BaseConnectionFactory;
use Illuminate\Database\PostgresConnection;
use Illuminate\Database\SQLiteConnection;
use Illuminate\Database\SqlServerConnection;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use Override;
use PDO;
use PDOException;

class ConnectionFactory extends BaseConnectionFactory
{
    /**
     * Carbon copy of parent. Except Laravel creates an "uncatchable" exception,
     * this is resolved as part of the override below.
     *
     * @return Closure
     */
    #[Override]
    protected function createPdoResolverWithHosts(array $config)
    {
        return function() use ($config) {
            $lastException = null;
            foreach (Arr::shuffle($hosts = $this->parseHosts($config)) as $host) {
                $config['host'] = $host;

                try {
                    return $this->createConnector($config)->connect($config);
                } catch (PDOException $e) {
                    $lastException = $e;
                }
            }

            if (!is_null($lastException)) {
                throw $lastException;
            }
        };
    }

    /**
     * Create a new connection instance.
     *
     * @param string $driver
     * @param PDO $connection
     * @param string $database
     * @param string $prefix
     * @return Connection
     *
     * @throws InvalidArgumentException
     */
    #[Override]
    protected function createConnection($driver, $connection, $database, $prefix = '', array $config = [])
    {
        if ($resolver = Connection::getResolver($driver)) {
            return $resolver($connection, $database, $prefix, $config);
        }

        return match ($driver) {
            'mysql' => new MySqlConnection($connection, $database, $prefix, $config),
            'pgsql' => new PostgresConnection($connection, $database, $prefix, $config),
            'sqlite' => new SQLiteConnection($connection, $database, $prefix, $config),
            'sqlsrv' => new SqlServerConnection($connection, $database, $prefix, $config),
            default => throw new InvalidArgumentException(sprintf('Unsupported driver [%s]', $driver)),
        };
    }
}
