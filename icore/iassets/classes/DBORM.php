<?php

class DBORM extends DBConnect
{

    private $EffectTableName;

    public function __construct($dbConnection)
    {
        parent::__construct($dbConnection);

    }

    //------ data select row by idrow
    public function DataSelect($IdRow, $SFilds, $TableName)
    {

        $SCondition = "IdRow='$IdRow' ";
        return (parent::SelectRowL($SFilds, $TableName, $SCondition));

    }

    //------ data select row by idkey
    public function DataSelectIdKey($IdKey, $SFilds, $TableName)
    {

        $SCondition = "IdKey='$IdKey' ";
        return (parent::SelectRowL($SFilds, $TableName, $SCondition));

    }

    //-------  data exist in table
    public function DataExist($SCondition, $TableName)
    {

        if (parent::CountRow($TableName, $SCondition) != 0) {
            return true;
        } else {
            return false;
        }

    }

    //------- data count

    public function DataCount($SCondition, $TableName)
    {
        return parent::CountRow($TableName, $SCondition);
    }

    //------- find unique data in table

    public function DataUnique($SCondition, $TableName)
    {
        if (parent::CountRow($TableName, $SCondition) == 1) {
            return true;
        } else {
            return false;
        }

    }

    //------ add data in table
    public function DataAdd($InSet, $TableName)
    {

        return (parent::Insert($TableName, $InSet));

    }

    //------- update select row
    public function DataUpdate($UCondition, $USet, $TableName)
    {

        return (parent::Update($TableName, $USet, $UCondition));

    }

    //------- delete select row
    public function DeleteRow($DCondition, $TableName)
    {
        return (parent::Delete($TableName, $DCondition));

    }

    //------ fetch all data
    public function FetchAll($SCondition, $SFilds, $TableName)
    {

        return (parent::SelectColumnL($SFilds, $TableName, $SCondition));

    }

    //------ fetch all data whitout condition
    public function FetchAllWhitoutCondition($SFilds, $TableName)
    {

        return (parent::SelectColumnL($SFilds, $TableName, 1));

    }

    //------ fetch limit data
    public function FetchLimit($SCondition, $SFilds, $IndexSet, $Limit, $TableName)
    {
        return (parent::SelectColumn($SFilds, $TableName, $SCondition, $IndexSet, $Limit));

    }

    //------- fetch data
    public function Fetch($SCondition, $SFilds, $TableName)
    {
        return (parent::SelectRowL($SFilds, $TableName, $SCondition));

    }

    //------- Move
    public function Move($IdRow, $IdRowCahngeTo, $TableName)
    {
        parent::Sort2Id($IdRow, $IdRowCahngeTo, $TableName);

    }


    //------- run store procedure data
    public function FetchSP($Value, $SPName)
    {
        return (parent::SelectSp($Value, $SPName));

    }

    //------ run function data

    public function  FetchFunc($Value, $FuncName)
    {
        return (parent::SelectFunc($Value, $FuncName));
    }

    //-------

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
        return (parent::ShowTableColumn($Table));
    }

    public function CallProcedure($ProName)
    {
        parent::CallProcedure($ProName);
    }

    public function CallProcedureValue($ProName,$Value)
    {
        return (parent::CallProcedureValue($ProName,$Value));
    }


}
