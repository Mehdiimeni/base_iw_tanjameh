<?php
//PageTitleTop.php

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include IW_ASSETS_FROM_PANEL . "include/UserInfo.php";
$strNewUser = 0;
$strSuper = 0;
if ($stdProfile->ApiId != null) {
    $strNewUser = 1;
}

if ($strUserGroup->SuperUser or $strUserGroup->SuperTrade)
    $strSuper = 1;

$Enabled = BoolEnum::BOOL_TRUE();

$strPart = $objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->part;
$strPage = $objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->page;
$strModify = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJsonNoSet())->modify;

$SCondition = "Name = '$strPart' and  Enabled = '$Enabled' ";
$stdPart = $objORM->Fetch($SCondition, 'PartName', TableIWPanelUserPart);

$SCondition = "Name = '$strPage' and  Enabled = '$Enabled' ";
$stdPage = $objORM->Fetch($SCondition, 'PageName,TopModify', TableIWPanelUserPage);
$blModify = $stdPage->TopModify;

include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

