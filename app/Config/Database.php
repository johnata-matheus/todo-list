<?php

namespace App\Config;

use PDOException;

class Database
{
    public static function getConnection(): \PDO
    {
        $host     = $_ENV['DB_HOST'];
        $dbname   = $_ENV['DB_NAME'];
        $user     = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASSWORD'];
        $port     = $_ENV['DB_PORT'];

        try {
            $conn = new \PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $password);
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            return $conn;
        } catch (\PDOException $e) {
            error_log('Erro ao se conectar ao banco de dados' . $e->getMessage());
            throw new PDOException('Não foi possível conectar ao banco de dados.');
        }
    }
}
