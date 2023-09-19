<?php
class DBORM extends DBConnect
{
    private $EffectTableName;

    public function __construct($dbConnection)
    {
        parent::__construct($dbConnection);
    }

    public function DataSelect($id, $SFilds, $TableName)
    {
        $SCondition = "id=$id ";
        return parent::SelectRowL($SFilds, $TableName, $SCondition);
    }

    public function DataSelectIdKey($id, $SFilds, $TableName)
    {
        $SCondition = "id=$id ";
        return parent::SelectRowL($SFilds, $TableName, $SCondition);
    }

    public function DataExist($SCondition, $TableName, $Row = 'id')
    {
        return parent::CountRow($TableName, $SCondition, $Row) != 0;
    }

    public function DataCount($SCondition, $TableName, $Row = 'id')
    {
        return parent::CountRow($TableName, $SCondition, $Row);
    }

    public function DataUnique($SCondition, $TableName, $Row = 'id')
    {
        return parent::CountRow($TableName, $SCondition, $Row) == 1;
    }

    public function DataAdd($InSet, $TableName)
    {
        return parent::Insert($TableName, $InSet);
    }

    public function DataUpdate($UCondition, $USet, $TableName)
    {
        return parent::Update($TableName, $USet, $UCondition);
    }

    public function DeleteRow($DCondition, $TableName)
    {
        return parent::Delete($TableName, $DCondition);
    }

    public function FetchAll($SCondition, $SFilds, $TableName)
    {
        return parent::SelectColumnL($SFilds, $TableName, $SCondition);
    }

    public function FetchAllWhitoutCondition($SFilds, $TableName)
    {
        return parent::SelectColumnL($SFilds, $TableName, 1);
    }

    public function FetchLimit($SCondition, $SFilds, $IndexSet, $Limit, $TableName)
    {
        return parent::SelectColumn($SFilds, $TableName, $SCondition, $IndexSet, $Limit);
    }

    public function FetchJson($TableName, $SCondition, $SFilds, $IndexSet = 'id', $Limit = 10)
    {
        return parent::SelectJson($SFilds, $TableName, $SCondition, $IndexSet, $Limit);
    }

    public function FetchJsonWhitoutCondition($TableName, $SCondition, $SFilds)
    {
        return parent::SelectJsonWhitoutCondition($SFilds, $TableName, $SCondition);
    }

    public function Fetch($SCondition, $SFilds, $TableName)
    {
        return parent::SelectRowL($SFilds, $TableName, $SCondition);
    }

    public function Move($id, $idCahngeTo, $TableName)
    {
        parent::Sort2Id($id, $idCahngeTo, $TableName);
    }

    public function FetchSP($Value, $SPName)
    {
        return parent::SelectSp($Value, $SPName);
    }

    public function FetchFunc($Value, $FuncName)
    {
        return parent::SelectFunc($Value, $FuncName);
    }

    public function TableDelete($Table)
    {
        parent::TableDrop($Table);
    }

    public function TableEmpty($Table)
    {
        parent::TRUNCATE($Table);
    }

    public function CreateTable($TableName, array $TableColumn)
    {
        parent::CreateTable($TableName, $TableColumn);
    }

    public function AlterTableAdd($Table, $ColumnString)
    {
        parent::AlterTableAdd($Table, $ColumnString);
    }

    public function AlterTableDrop($Table, $Column)
    {
        parent::AlterTableDrop($Table, $Column);
    }

    public function CreateTriggersDelete($MainTable, $SecTable, $OnColumn, $Name)
    {
        parent::CreateTriggerDelete($MainTable, $SecTable, $OnColumn, $Name);
    }

    public function ShowTableColumn($Table)
    {
        return parent::ShowTableColumn($Table);
    }

    public function CallProcedure($ProName)
    {
        parent::CallProcedure($ProName);
    }

    public function CallProcedureValue($ProName, $Value)
    {
        return parent::CallProcedureValue($ProName, $Value);
    }
}
