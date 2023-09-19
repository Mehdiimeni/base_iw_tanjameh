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
        return $this->executeQuery("SELECT $Fields FROM $Table WHERE $Condition ORDER BY $IndexSet")->fetch(PDO::FETCH_OBJ);
    }

    public function SelectRowL($Fields, $Table, $Condition)
    {
        return $this->executeQuery("SELECT $Fields FROM $Table WHERE $Condition")->fetch(PDO::FETCH_OBJ);
    }

    public function SelectColumn($Fields, $Table, $Condition, $IndexSet, $Limit)
    {
        return $this->executeQuery("SELECT $Fields FROM $Table WHERE $Condition ORDER BY $IndexSet LIMIT $Limit")->fetchAll(PDO::FETCH_OBJ);
    }

    public function SelectColumnL($Fields, $Table, $Condition)
    {
        return $this->executeQuery("SELECT $Fields FROM $Table WHERE $Condition")->fetchAll(PDO::FETCH_OBJ);
    }

    public function Insert($Table, $Set): bool
    {
        $Set = parent::Nu2EN($Set);
        $Query = "INSERT INTO $Table SET $Set ";

        $stmt = $this->dbConnection->prepare($Query);
        $stmt->execute();
        return $stmt->rowCount() > 0 ? $this->LastId() : false;
    }

    public function Update($Table, $Set, $Condition): bool
    {
        $Set = parent::Nu2EN($Set);
        $Query = "UPDATE $Table  SET $Set WHERE $Condition ";

        $stmt = $this->dbConnection->prepare($Query);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function Delete($Table, $Condition): bool
    {
        $Query = "DELETE FROM $Table WHERE $Condition ";
        $stmt = $this->dbConnection->prepare($Query);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function CountRow($Table, $Condition, $Row): int
    {
        $Query = "SELECT $Row FROM $Table WHERE $Condition ";
        $stmt = $this->executeQuery($Query);
        return $stmt->rowCount();
    }

    public function Sort2Id($id, $FirstItem, $Table): bool
    {
        $UTable = " $Table ";
        $USet = " id='0' ";
        $UCondition = " id='$id' ";

        $this->Update($UTable, $USet, $UCondition);
        $USet = " id='$id' ";
        $UCondition = " id='$FirstItem' ";
        $this->Update($UTable, $USet, $UCondition);
        $USet = " id='$FirstItem' ";
        $UCondition = " id='0' ";
        $this->Update($UTable, $USet, $UCondition);
        return true;
    }

    public function LastId()
    {
        return ($this->dbConnection->lastInsertId());
    }

    public function SelectSp($Value, $SPName)
    {
        $Query = "CALL $SPName($Value) ";
        return $this->executeQuery($Query)->fetchAll(PDO::FETCH_OBJ);
    }

    public function CallProcedure($ProName)
    {
        $Query = "CALL $ProName() ";
        $stmt = $this->dbConnection->prepare($Query);
        $stmt->execute();
    }

    public function CallProcedureValue($ProName, $Value)
    {
        $Query = "CALL $ProName($Value) ";
        return $this->executeQuery($Query)->fetchAll(PDO::FETCH_OBJ);
    }

    public function SelectFunc($Value, $FuncName)
    {
        $Query = "SELECT $FuncName($Value) AS Result ";
        return $this->executeQuery($Query)->fetchAll(PDO::FETCH_OBJ);
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
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `IdKey` varchar(11) NOT NULL,
                      `Enabled` tinyint(1) NOT NULL DEFAULT '0',
                      `ModifyIP` varchar(15) NOT NULL,
                      `created_time` varchar(8) NOT NULL,
                      `last_modify` varchar(10) NOT NULL,
                      `ModifyStrTime` varchar(26) NOT NULL,
                      `ModifyId` varchar(11) NOT NULL,
                       PRIMARY KEY (`id`),
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
                  for EACH ROW DELETE FROM $SecTable WHERE $SecTable.$OnColumn = old.IdKey";

        $stmt = $this->dbConnection->prepare($Query);
        $stmt->execute();
    }

    public function ShowTableColumn($Table)
    {
        $Query = "SELECT group_concat(COLUMN_NAME) FROM INFORMATION_SCHEMA.COLUMNS WHERE  TABLE_NAME = '$Table' ";
        return $this->executeQuery($Query)->fetchAll(PDO::FETCH_OBJ);
    }

    public function SelectJson($Fields, $Table, $Condition, $IndexSet, $Limit)
    {
        $Query = "SELECT $Fields FROM $Table WHERE $Condition ORDER BY $IndexSet LIMIT $Limit ";
        $results = $this->executeQuery($Query)->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($results);
    }

    public function SelectJsonWhitoutCondition($Fields, $Table, $Condition)
    {
        $Query = "SELECT $Fields FROM $Table WHERE $Condition  ";
        $results = $this->executeQuery($Query)->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($results);
    }

    private function executeQuery($query)
    {
        $sql = $this->dbConnection->prepare($query);
        $sql->execute();
        return $sql;
    }
}
