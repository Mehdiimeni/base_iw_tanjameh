<?php
//PageTitleTop.php

include IW_ASSETS_FROM_PANEL."include/DBLoader.php";


$Enabled = BoolEnum::BOOL_TRUE();

$strPart = $objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->part;
$strPage = $objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->page;
$strModify = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJsonNoSet())->modify;

$SCondition = "Name = '$strPart' and  Enabled = '$Enabled' ";
$stdPart = $objORM->Fetch($SCondition, 'PartName', TableIWPanelAdminPart);

$SCondition = "Name = '$strPage' and  Enabled = '$Enabled' ";
$stdPage = $objORM->Fetch($SCondition, 'PageName,TopModify', TableIWPanelAdminPage);

$blModify = isset($stdPage->TopModify) ? $blModify = $stdPage->TopModify : $blModify = 0; 

include IW_ASSETS_FROM_PANEL."include/IconTools.php";

