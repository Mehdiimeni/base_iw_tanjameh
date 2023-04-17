<?php
require_once "iassets/interfaces/DBConnectionInterface.php";

final class MSSQLDBConnection implements DBConnectionInterface
{
    public $PConn;
    public function connect()
    {
        try {

            $this->PConn = new PDO('sqlsrv:Server=192.168.80.3;Database=RNLS2BO', 'm.ghorbanalibeik', 'M123!@#qwe');
            $this->PConn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->PConn->setAttribute(\PDO::ATTR_PERSISTENT, true);
            var_dump($this->PConn);
        } catch (\PDOException $e) {
            throw new\ PDOException($e->getMessage());
        }
    }

    public function showdata()
    {
        var_dump($this->PConn);
    }
}