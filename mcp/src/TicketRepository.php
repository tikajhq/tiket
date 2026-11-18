<?php

declare(strict_types=1);

namespace Tiket\Mcp;

use PDO;
use RuntimeException;

final class TicketRepository
{
    public static function connect(): PDO
    {
        $projectRoot = dirname(__DIR__, 2);

        if (!defined('BASEPATH')) {
            define('BASEPATH', $projectRoot . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR);
        }

        if (!defined('ENVIRONMENT')) {
            define('ENVIRONMENT', 'production');
        }

        $active_group = 'default';
        $query_builder = true;
        $db = [];
        require $projectRoot . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'database.php';

        if (!isset($db[$active_group])) {
            throw new RuntimeException('The CodeIgniter default database group is not configured.');
        }

        $config = $db[$active_group];
        if (!in_array($config['dbdriver'], ['mysqli', 'mysql'], true)) {
            throw new RuntimeException('The MCP server currently supports MySQL connections only.');
        }

        $dsn = $config['dsn'];
        if ($dsn === '') {
            $dsn = 'mysql:host=' . $config['hostname'];
            if (!empty($config['port'])) {
                $dsn .= ';port=' . (int) $config['port'];
            }
            $dsn .= ';dbname=' . $config['database'];
            $dsn .= ';charset=' . ($config['char_set'] ?: 'utf8mb4');
        }

        return new PDO(
            $dsn,
            $config['username'],
            $config['password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_TIMEOUT => 5,
            ]
        );
    }
}
