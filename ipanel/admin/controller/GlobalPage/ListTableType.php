<?php
//ListTableType.php
$objGlobalVar = new GlobalVarTools();

@$_SESSION['strListSet'] == null ? $strList = @$_GET['list'] : $strList = $_SESSION['strListSet'];
if(@$strList == null)
{
    $strListType = '<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap">';
    $strNameTableGrid = "datatable-responsive";

}elseif($strList == 'export')
{
    $strListType = '<table id="datatable-buttons" class="table table-striped table-bordered  ">';
    $strNameTableGrid = "datatable-buttons";

}elseif($strList == 'normal')
{
    $strListType = '<table id="datatable-normal"  class="table table-striped table-bordered dt-responsive nowrap">';
    $strNameTableGrid = "datatable-responsive";
} else
{
    $strListType = '<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap">';
    $strNameTableGrid = "datatable-responsive";
}

$_SESSION['strListSet'] = '';