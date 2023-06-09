<?php
// MenuView.php

require_once "../vendor/autoload.php";
SessionTools::init();
require_once "../icore/idefine/conf/root.php";
require_once "../icore/idefine/conf/tablename.php";

$objGlobalVar = new GlobalVarTools();
$objFileToolsDBInfo = (new FileTools(IW_DEFINE_FROM_PANEL . "conf/online.iw"))->KeyValueFileReader();

if ((new IPTools(IW_DEFINE_FROM_PANEL))->getHostAddressLoad() == 'localhost')
    $objFileToolsDBInfo = (new FileTools(IW_DEFINE_FROM_PANEL . "conf/local.iw"))->KeyValueFileReader();

$objORM = new DBORM((new MySQLConnection($objFileToolsDBInfo))->getConn());
$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");

// user profile

$Enabled = true;
if (isset($_GET['NewMenuId'])) {
    $GroupIdKey = $_GET['NewMenuId'];
    $SCondition = "iw_new_menu_id = $GroupIdKey ";

    echo '<option value="" selected></option>';
    foreach ($objORM->FetchAll($SCondition, 'LocalName,id', TableIWNewMenu2) as $ListItem) {
        if ($ListItem->LocalName == '')
            continue;
        echo '<option value="' . $ListItem->id . '" >' . $ListItem->LocalName . '</option>';
    }
}

if (isset($_GET['NewMenu2Id'])) {
    $GroupIdKey = $_GET['NewMenu2Id'];
    $SCondition = "iw_new_menu_2_id = $GroupIdKey ";

    echo '<option value="" selected></option>';
    foreach ($objORM->FetchAll($SCondition, 'LocalName,id', TableIWNewMenu3) as $ListItem) {
        if ($ListItem->LocalName == '')
            continue;
        echo '<option value="' . $ListItem->id . '" >' . $ListItem->LocalName . '</option>';
    }
}
