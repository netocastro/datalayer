<?php

namespace NTTech\DataLayer;

use PDO;
use PDOException;

/**
 * Class Connect
 * @package NTTech\DataLayer
 */
class Connect
{
    /** @var array */
    private static array $instance;

    /** @var PDOException|null */
    private static ?PDOException $error = null;

    /**
     * @param array|null $database
     * @return PDO|null
     */
    public static function getInstance(array $database = null): ?PDO
    {
        $dbConf = $database ?? DATA_LAYER_CONFIG;
        $dbName = "{$dbConf["driver"]}-{$dbConf["dbname"]}@{$dbConf["host"]}";
        $dbDsn = $dbConf["driver"] . ":host=" . $dbConf["host"] . ";dbname=" . $dbConf["dbname"] . ";port=" . $dbConf["port"];

        //DSN alternative for SQL Server (sqlsrv)
        if ($dbConf['driver'] == 'sqlsrv') {
            $dbDsn = $dbConf["driver"] . ":Server=" . $dbConf["host"] . "," . $dbConf["port"] . ";Database=" . $dbConf["dbname"];
        }

        if (empty(self::$instance[$dbName])) {
            try {
                self::$instance[$dbName] = new PDO(
                    $dbDsn,
                    $dbConf["username"],
                    $dbConf["passwd"],
                    $dbConf["options"]
                );
            } catch (PDOException $exception) {
                self::$error = $exception;
            }
        }

        return self::$instance[$dbName];
    }

    /**
     * @param string|null $database
     * @return PDO
     */
    public static function testConnection(?string $database = null): PDO
    {
        $connect = self::getInstance($database);

        if (is_null($connect) || !$connect instanceof PDO) {
            throw (self::getError($database) ?? new PDOException("Unknown key or database '{$database}'"));
        }

        return $connect;
    }


    /**
     * @return PDOException|null
     */
    public static function getError(): ?PDOException
    {
        return self::$error;
    }

    /**
     * Connect constructor.
     */
    private function __construct()
    {
    }

    /**
     * Connect clone.
     */
    private function __clone()
    {
    }
}
