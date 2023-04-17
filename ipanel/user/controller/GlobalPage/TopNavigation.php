<?php
//TopNavigation.php
require IW_ASSETS_FROM_PANEL."include/DBLoader.php";
$Enabled = BoolEnum::BOOL_TRUE();
$UserIdKey = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));

$SCondition = "IdKey = '$UserIdKey' and  Enabled = '$Enabled' ";
$stdProfile = $objORM->Fetch($SCondition, 'Name,Image,IdKey', TableIWUser);

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);

$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL.'img/');
$UserProfileImage = $objShowFile->ShowImage( '', $objShowFile->FileLocation( "userprofile" ), $stdProfile->Image, $stdProfile->Name, 0, '' );


