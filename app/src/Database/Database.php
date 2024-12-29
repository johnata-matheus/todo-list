<?php

namespace App\Database;

use PDO;
use PDOException;

class Database 
{
  public static function getConnection() 
  {
    $host = $_ENV['DB_HOST'];
    $dbname = $_ENV['DB_NAME'];
    $user = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASSWORD'];
    $port = $_ENV['DB_PORT'];

    try {
      $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $conn;
    } catch(PDOException $e) {
      echo "Erro ao se conectar ao banco de dados" . $e->getMessage();
    }
  }
}