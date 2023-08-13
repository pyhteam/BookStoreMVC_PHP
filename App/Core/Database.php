<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static $instance;
    private $connection;
    private $logger;
    private function __construct()
    {
        $this->logger = new Logger();
        $config = new Config();
        $dbName = $config->get('db_name');
        $dbHost = $config->get('db_host');
        $dbUser = $config->get('db_user');
        $dbPassword = $config->get('db_password');

        try {
            $this->connection = new PDO(
                'mysql:host=' . $dbHost . ';dbname=' . $dbName . ';charset=utf8',
                $dbUser,
                $dbPassword
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->logger->log($e->getMessage(), 'error');
            die("Connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function query($query, $params = [])
    {
        try {
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        } catch (PDOException $e) {
            $this->logger->log($e->getMessage(), 'error');
            die("Query failed: " . $e->getMessage());
        }
    }
    // fetch to all
    public function fetch($query, $params = [])
    {
        $statement = $this->query($query, $params);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // fetch to one
    public function fetch_one($query, $params = [])
    {
        $statement = $this->query($query, $params);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    // count
    public function count($query, $params = [])
    {
        $statement = $this->query($query, $params);
        return $statement->rowCount();
    }
}
