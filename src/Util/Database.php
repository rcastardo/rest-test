<?php

namespace Acme\Util;

use PDO;

class Database
{
    private static $conn = null;

    private function __construct()
    {
    }

    public static function getConnection()
    {
        if (self::$conn === NULL) {
            $dsn = 'sqlite:.\db\rest-test.sqlite';
            self::$conn = new PDO($dsn);

            if(!self::$conn) {
                throw new \RuntimeException(self::$conn->lastErrorMsg());
            }

            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$conn->exec("CREATE TABLE IF NOT EXISTS users(id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, email TEXT)");
        }
        return self::$conn;
    }

}
