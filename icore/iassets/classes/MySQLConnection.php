<?php

final class MySQLConnection implements DBConnectionInterface
{
    private $Host;
    private $Database;
    private $User;
    private $Password;
    private $IP;
    private $Port;
    private $pdoConnection;


    public function __construct(array $array)
    {
        $this->Host = base64_decode(base64_decode($array['Host']));
        $this->Database = base64_decode(base64_decode($array['Database']));
        $this->User = base64_decode(base64_decode($array['User']));
        $this->Password = base64_decode(base64_decode($array['Password']));
        $this->pdoConnection = null;

    }

    public function connect()
    {

        try {
            strtolower($this->Password) == 'null' ? $this->Password = '' : $this->Password;
            $dsn = "mysql:host={$this->Host};dbname={$this->Database};charset=utf8";
            $options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            ];
            $this->pdoConnection = new \PDO($dsn, $this->User, $this->Password, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
    }

    public function getConn()
    {
        if ($this->pdoConnection === null) {
            $this->connect();
        }
        return $this->pdoConnection;
    }
}
