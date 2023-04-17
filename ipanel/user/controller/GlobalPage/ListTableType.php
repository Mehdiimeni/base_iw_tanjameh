<?php
//ListTableType.php
$objGlobalVar = new GlobalVarTools();
$strList = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->list;
if($strList == null)
{
    $strListType = '<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap">';
}elseif($strList == 'export')
{
    $strListType = '<table id="datatable-buttons" class="table table-striped table-bordered  ">';

}else
{
    $strListType = '<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap">';
}