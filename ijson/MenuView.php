<?php
// MenuView.php

require_once "../vendor/autoload.php";
SessionTools::init();
require_once "../idefine/conf/root.php";
require_once "../idefine/conf/tablename.php";

$objGlobalVar = new GlobalVarTools();
$objFileToolsDBInfo = (new FileTools(IW_DEFINE_FROM_PANEL . "conf/online.iw"))->KeyValueFileReader();

if ((new IPTools(IW_DEFINE_FROM_PANEL))->getHostAddressLoad() == 'localhost')
    $objFileToolsDBInfo = (new FileTools(IW_DEFINE_FROM_PANEL . "conf/local.iw"))->KeyValueFileReader();

$objORM = new DBORM((new MySQLConnection($objFileToolsDBInfo))->getConn());
$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");

// user profile

$Enabled = BoolEnum::BOOL_TRUE();
if(isset($_GET['PGenderIdKey'])) {
    $GroupIdKey = $_GET['PGenderIdKey'];
    $arrGroupIdKey= explode("==::==", @$GroupIdKey);
    $SCondition = "GroupIdKey = '$arrGroupIdKey[0]'";
    echo '<option value="" selected></option>';
    foreach ($objORM->FetchAll($SCondition, 'Name,LocalName,IdKey', TableIWWebSubMenu) as $ListItem) {
        if ($ListItem->LocalName == '')
            continue;
        echo '<option value="' . $ListItem->IdKey.'==::=='.$ListItem->Name .'" >' . $ListItem->LocalName . '</option>';
    }
}

if(isset($_GET['PCategoryIdKey'])) {
    $GroupIdKey = $_GET['PCategoryIdKey'];
    $arrGroupIdKey= explode("==::==", @$GroupIdKey);
    $SCondition = "GroupIdKey = '$arrGroupIdKey[0]'";
    echo '<option value="" selected></option>';
    foreach ($objORM->FetchAll($SCondition, 'IdKey,LocalName,Name', TableIWWebSub2Menu) as $ListItem) {
        if ($ListItem->LocalName == '')
            continue;
        echo '<option value="' . $ListItem->IdKey.'==::=='.$ListItem->Name .'" >' . $ListItem->LocalName . '</option>';
    }
}