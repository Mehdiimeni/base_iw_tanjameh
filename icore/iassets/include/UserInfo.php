<?php
//UserInfo.php

require IW_ASSETS_FROM_PANEL . "include/DBLoader.php";

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");

// user profile
$Enabled = BoolEnum::BOOL_TRUE();
$UserIdKey = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));
$SCondition = "IdKey = '$UserIdKey' and  Enabled = '$Enabled' ";
$stdProfile = $objORM->Fetch($SCondition, 'Name,Image,GroupIdKey,CountEnter,ApiId,GroupApiId', TableIWUser);

$SCondition = "IdKey = '$stdProfile->GroupIdKey'";
$strUserGroup = @$objORM->Fetch($SCondition, 'Name,ApiId,IdKey,SuperUser,SuperTrade', TableIWUserGroup);
$strUserGroupName = @$strUserGroup->Name;

$SCondition = "GroupIdKey = '$stdProfile->GroupIdKey'";
$objUserAccess = @$objORM->Fetch($SCondition, 'AllAccess,AllTrade', TableIWUserAccess);
$arrAccess = $objGlobalVar->JsonDecodeArray($objUserAccess->AllAccess);
$arrAllTrade = $objGlobalVar->JsonDecodeArray($objUserAccess->AllTrade);

