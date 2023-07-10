<?php
//MenuProfileQuickInfo.php
require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";

$Enabled = true;
$iw_admin_id = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

$stdProfile = $objORM->Fetch(
    "iw_admin_id = $iw_admin_id",
    "Name,Image",
    TableIWAdminProfile
);

$strAdminGroupName = @$objORM->Fetch(
    $objORM->Fetch("id = $iw_admin_id", "iw_admin_group_id", TableIWAdmin)->iw_admin_group_id,
    'Name',
    TableIWAdminGroup
)->Name;

if (isset($stdProfile->Image)) {
    $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
    $objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
    $objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');
    $objShowFile->ShowImage('', $objShowFile->FileLocation("adminprofile"), $stdProfile->Image, $stdProfile->Name, 85, '') != null ? $AdminProfileImage = $objShowFile->ShowImage('', $objShowFile->FileLocation("adminprofile"), $stdProfile->Image, $stdProfile->Name, 85, '') : $AdminProfileImage = null;
} else {
    $AdminProfileImage = null;
}