<?php

class PdoConnection
{
    private static $dbms = 'mysql';
    private static $host = '127.0.0.1';
    private static $dbName = 'homestead';
    private static $dbUser = 'homestead';
    private static $dbPass = 'secret';

    private $pdo;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        $this->pdo = new \PDO(
            sprintf("%s:host=%s;dbname=%s", self::$dbms, self::$host, self::$dbName),
            self::$dbUser,
            self::$dbPass,
            [
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8MB4'",
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            ]
        );
    }

    public function beginTransaction()
    {
        return $this->pdo->beginTransaction();
    }

    public function rollBack()
    {
        return $this->pdo->rollBack();
    }

    public function commit()
    {
        return $this->pdo->commit();
    }

    public function prepareAndExecute($statement, array $parameters)
    {
        $this->sth = $this->pdo->prepare($statement);
        $this->sth->execute($parameters);
    }

    public function fetch($condition = \PDO::FETCH_ASSOC)
    {
        return $this->sth->fetch($condition);
    }

    public function query($statement)
    {
        return $this->pdo->query($statement);
    }
}