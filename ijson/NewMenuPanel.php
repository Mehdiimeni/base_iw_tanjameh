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
if (isset($_GET['NewMenuId'])) {
    $GroupIdKey = $_GET['NewMenuId'];
    $SCondition = "GroupIdKey = '$GroupIdKey' ";

    echo '<option value="" selected></option>';
    foreach ($objORM->FetchAll($SCondition, 'LocalName,IdKey', TableIWNewMenu2) as $ListItem) {
        if ($ListItem->LocalName == '')
            continue;
        echo '<option value="' . $ListItem->IdKey . '" >' . $ListItem->LocalName . '</option>';
    }
}

if (isset($_GET['NewMenu2Id'])) {
    $GroupIdKey = $_GET['NewMenu2Id'];
    $SCondition = "GroupIdKey = '$GroupIdKey' ";

    echo '<option value="" selected></option>';
    foreach ($objORM->FetchAll($SCondition, 'LocalName,IdKey', TableIWNewMenu3) as $ListItem) {
        if ($ListItem->LocalName == '')
            continue;
        echo '<option value="' . $ListItem->IdKey . '" >' . $ListItem->LocalName . '</option>';
    }
}
