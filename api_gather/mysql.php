<?php

class Database
{
    private static $instance;
    private $host;
    private $user;
    private $password;
    private $database;

    public function __construct()
    {
        if ($_SERVER['SERVER_NAME'] === 'localhost') {
            $this->host = 'localhost';
            $this->user = 'root';
            $this->password = '';
            $this->database = 'new_tanjameh';
        } else {
            $this->host = 'localhost';
            $this->user = 'api_gather';
            $this->password = '45s@k9s4K';
            $this->database = 'new_tanjameh';
        }
    }


    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
        if ($conn->connect_error) {
            die("Error failed to connect to MySQL: " . $conn->connect_error);
        } else {
            return $conn;
        }
    }
}
?>