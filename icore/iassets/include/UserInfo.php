<?php
//UserInfo.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");

// user profile
$Enabled = true;
$UserId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserId'));
$SCondition = "id = '$UserId' and  Enabled = $Enabled ";
$stdProfile = $objORM->Fetch($SCondition, 'Name,Image,GroupIdKey,CountEnter,ApiId,GroupApiId', TableIWUser);

$SCondition = "id = '$stdProfile->GroupIdKey'";
$strUserGroup = @$objORM->Fetch($SCondition, 'Name,ApiId,IdKey,SuperUser,SuperTrade', TableIWUserGroup);
$strUserGroupName = @$strUserGroup->Name;

$SCondition = "GroupIdKey = '$stdProfile->GroupIdKey'";
$objUserAccess = @$objORM->Fetch($SCondition, 'AllAccess,AllTrade', TableIWUserAccess);
$arrAccess = $objGlobalVar->JsonDecodeArray($objUserAccess->AllAccess);
$arrAllTrade = $objGlobalVar->JsonDecodeArray($objUserAccess->AllTrade);

