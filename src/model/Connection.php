<?php
class Connection
{
  // Para hacer que no exista más de una conexión la declaramos estática
  private static $connection;

  public static function connect()
  {
    try {
      if (!isset(self::$connection)) {
        self::$connection = new PDO("mysql:host=127.0.0.1; dbname=banco", "root", "");
        self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$connection->exec("SET CHARACTER SET UTF8");
      }
      return self::$connection;
    } catch (Exception $e) {
      die("Algo salió mal: {$e->getMessage()}");
    }
  }

  public static function close(&$conn) {
    $conn = null;
  }
}
