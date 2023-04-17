<?php
//MenuProfileQuickInfo.php
require IW_ASSETS_FROM_PANEL."include/DBLoader.php";

$Enabled = BoolEnum::BOOL_TRUE();
$UserIdKey = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));

$SCondition = "IdKey = '$UserIdKey' and  Enabled = '$Enabled' ";
$stdProfile = $objORM->Fetch($SCondition, 'Name,Image,GroupIdKey,CountEnter', TableIWUser);


$SCondition = "IdKey = '$stdProfile->GroupIdKey'";
$strUserGroupName = @$objORM->Fetch($SCondition,'Name',TableIWUserGroup)->Name;

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);

$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL.'img/');
$UserProfileImage = $objShowFile->ShowImage( '', $objShowFile->FileLocation( "userprofile" ), $stdProfile->Image, $stdProfile->Name, 85, 'class="img-circle profile_img"' );

