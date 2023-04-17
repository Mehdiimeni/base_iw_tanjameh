<?php
//MenuProfileQuickInfo.php
require IW_ASSETS_FROM_PANEL."include/DBLoader.php";

$Enabled = BoolEnum::BOOL_TRUE();
$AdminIdKey = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminIdKey'));

$SCondition = "IdKey = '$AdminIdKey' and  Enabled = '$Enabled' ";
$stdProfile = $objORM->Fetch($SCondition, 'Name,Image,GroupIdKey', TableIWAdmin);


$SCondition = "IdKey = '$stdProfile->GroupIdKey' ";
$strAdminGroupName = @$objORM->Fetch($SCondition,'Name',TableIWAdminGroup)->Name;

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);

$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL.'img/');


$objShowFile->ShowImage( '', $objShowFile->FileLocation( "adminprofile" ), $stdProfile->Image, $stdProfile->Name, 85, 'class="img-circle profile_img"' ) != null ? $AdminProfileImage = $objShowFile->ShowImage( '', $objShowFile->FileLocation( "adminprofile" ), $stdProfile->Image, $stdProfile->Name, 85, 'class="img-circle profile_img"' ) : $AdminProfileImage = null;