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
if (isset($_POST['url_gender'])) {
    $GroupName = $_POST['url_gender'];
    $SCondition = "Name = '$GroupName'  ";
    $MenuId = $objORM->Fetch($SCondition, 'id', TableIWNewMenu)->id;

    $SCondition = "iw_new_menu_id = $MenuId  ";
    echo '<option value="" selected></option>';
    foreach ($objORM->FetchAll($SCondition, 'Name', TableIWNewMenu2) as $ListItem) {
        if ($ListItem->Name == '')
            continue;
        echo '<option value="' . $ListItem->Name . '" >' . $ListItem->Name . '</option>';
    }
}

if (isset($_POST['url_category'])) {
    $GroupName = $_POST['url_category'];
    $SCondition = "Name = '$GroupName'  ";
    $MenuId2 = $objORM->Fetch($SCondition, 'id', TableIWNewMenu2)->id;

    $SCondition = "iw_new_menu_2_id = $MenuId2  ";
    echo '<option value="" selected></option>';
    foreach ($objORM->FetchAll($SCondition, 'Name', TableIWNewMenu3) as $ListItem) {
        if ($ListItem->Name == '')
            continue;
        echo '<option value="' . $ListItem->Name . '" >' . $ListItem->Name . '</option>';
    }
}

if (isset($_POST['url_group'])) {
    $GroupName = $_POST['url_group'];
    $SCondition = "Name = '$GroupName'  ";
    $MenuId2 = $objORM->Fetch($SCondition, 'id', TableIWNewMenu3)->id;

    $SCondition = "iw_new_menu_3_id = $MenuId2  ";
    echo '<option value="" selected></option>';
    foreach ($objORM->FetchAll($SCondition, 'Name', TableIWNewMenu4) as $ListItem) {
        if ($ListItem->Name == '')
            continue;
        echo '<option value="' . $ListItem->Name . '" >' . $ListItem->Name . '</option>';
    }
}