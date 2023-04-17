<?php

class DBConnect extends Regularization
{
    private $dbConnection;

    public function __construct($dbConnection)
    {
        parent::__construct();
        $this->dbConnection = $dbConnection;
    }

    public function SelectRow($Fields, $Table, $Condition, $IndexSet)
    {
        $Query = "SELECT $Fields FROM $Table WHERE $Condition ORDER BY $IndexSet   ";
        $sql = $this->dbConnection->prepare($Query);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_OBJ);
    }

    public function SelectRowL($Fields, $Table, $Condition)
    {
        $Query = "SELECT $Fields FROM $Table WHERE $Condition  ";
        $sql = $this->dbConnection->prepare($Query);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_OBJ);
    }

    public function SelectColumn($Fields, $Table, $Condition, $IndexSet, $Limit)
    {
        $Query = "SELECT $Fields FROM $Table WHERE $Condition ORDER BY $IndexSet LIMIT $Limit ";
        $sql = $this->dbConnection->prepare($Query);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_OBJ);
    }

    public function SelectColumnL($Fields, $Table, $Condition)
    {
        $Query = "SELECT $Fields FROM $Table WHERE $Condition  ";
        $sql = $this->dbConnection->prepare($Query);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_OBJ);
    }

    public function Insert($Table, $Set): bool
    {
        $Set = parent::Nu2EN($Set);
        $Query = "INSERT INTO $Table SET $Set ";

        $stmt = $this->dbConnection->prepare($Query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $this->LastId();
        } else {
            return false;
        }
    }

    public function Update($Table, $Set, $Condition): bool
    {
        $Set = parent::Nu2EN($Set);
        $Query = "UPDATE $Table  SET $Set WHERE $Condition ";

        $stmt = $this->dbConnection->prepare($Query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function Delete($Table, $Condition): bool
    {
        $Query = "DELETE FROM $Table WHERE $Condition ";
        $stmt = $this->dbConnection->prepare($Query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function CountRow($Table, $Condition): int
    {

        $Query = "SELECT IdRow FROM $Table WHERE $Condition ";

        $stmt = $this->dbConnection->prepare($Query);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function Sort2Id($IdRow, $FirstItem, $Table): bool
    {
        $UTable = " $Table ";
        $USet = " IdRow='0' ";
        $UCondition = " IdRow='$IdRow' ";

        $this->Update($UTable, $USet, $UCondition);
        $USet = " IdRow='$IdRow' ";
        $UCondition = " IdRow='$FirstItem' ";
        $this->Update($UTable, $USet, $UCondition);
        $USet = " IdRow='$FirstItem' ";
        $UCondition = " IdRow='0' ";
        $this->Update($UTable, $USet, $UCondition);
        return (true);
    }

    public function LastId(): string
    {
        return ($this->dbConnection->lastInsertId());
    }


    public function SelectSp($Value, $SPName)
    {
        $Query = "CALL $SPName($Value) ";
        $sql = $this->dbConnection->prepare($Query);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_OBJ);
    }

    public function CallProcedure($ProName)
    {
        $Query = "CALL $ProName() ";
        $sql = $this->dbConnection->prepare($Query);
        $sql->execute();
    }

    public function CallProcedureValue($ProName,$Value)
    {
        $Query = "CALL $ProName($Value) ";
        $sql = $this->dbConnection->prepare($Query);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_OBJ);
    }

    public function SelectFunc($Value, $FuncName)
    {
        $Query = "SELECT $FuncName($Value) AS Result ";
        $sql = $this->dbConnection->prepare($Query);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_OBJ);
    }


    public function TableDrop($Table)
    {
        $Query = "DROP TABLE IF EXISTS $Table";
        $stmt = $this->dbConnection->prepare($Query);
        $stmt->execute();
    }

    public function TRUNCATE($Table)
    {
        $Query = "TRUNCATE TABLE  $Table";
        $stmt = $this->dbConnection->prepare($Query);
        $stmt->execute();
    }

    public function CreateTable($TableName, array $TableColumn)
    {
        $this->CreateTableBase($TableName);
        foreach ($TableColumn as $Column) {
            $this->AlterTableAdd($TableName, $Column);
        }

    }

    public function CreateTableBase($Table)
    {

        $Query = "CREATE TABLE IF NOT EXISTS $Table (
                      `IdRow` int(11) NOT NULL AUTO_INCREMENT,
                      `IdKey` varchar(11) NOT NULL,
                      `Enabled` tinyint(1) NOT NULL DEFAULT '0',
                      `ModifyIP` varchar(15) NOT NULL,
                      `ModifyTime` varchar(8) NOT NULL,
                      `ModifyDate` varchar(10) NOT NULL,
                      `ModifyStrTime` varchar(26) NOT NULL,
                      `ModifyId` varchar(11) NOT NULL,
                       PRIMARY KEY (`IdRow`),
                       UNIQUE KEY `IdKey` (`IdKey`)
                       ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8";

        $stmt = $this->dbConnection->prepare($Query);
        $stmt->execute();


    }

    public function AlterTableAdd($Table, $ColumnString)
    {
        $Query = "ALTER TABLE $Table ADD $ColumnString AFTER `Enabled` ";
        $stmt = $this->dbConnection->prepare($Query);
        $stmt->execute();
    }

    public function AlterTableDrop($Table, $Column)
    {
        $Query = "ALTER TABLE $Table DROP COLUMN  $Column  ";
        $stmt = $this->dbConnection->prepare($Query);
        $stmt->execute();
    }

    public function CreateTriggerDelete($MainTable, $SecTable, $OnColumn, $Name)
    {

        $Query = "CREATE TRIGGER $Name AFTER DELETE ON $MainTable
                  for EACH ROW DELETE FROM $SecTable WHERE $SecTable . $OnColumn = old . IdKey";

        $stmt = $this->dbConnection->prepare($Query);
        $stmt->execute();

    }

    public function ShowTableColumn($Table)
    {
        $Query = "SELECT group_concat(COLUMN_NAME) FROM INFORMATION_SCHEMA.COLUMNS WHERE  TABLE_NAME = '$Table' ";
        $sql = $this->dbConnection->prepare($Query);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_OBJ);

    }

}