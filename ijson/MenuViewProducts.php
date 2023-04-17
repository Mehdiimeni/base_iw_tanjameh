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
if (isset($_POST['PGenderName'])) {
    $GroupName = $_POST['PGenderName'];
    $SCondition = "Name = '$GroupName'  ";
    $MenuId = $objORM->Fetch($SCondition, 'IdKey', TableIWNewMenu)->IdKey;

    $SCondition = "GroupIdKey = '$MenuId'  ";
    echo '<option value="" selected></option>';
    foreach ($objORM->FetchAll($SCondition, 'Name', TableIWNewMenu2) as $ListItem) {
        if ($ListItem->Name == '')
            continue;
        echo '<option value="' . $ListItem->Name . '" >' . $ListItem->Name . '</option>';
    }
}

if (isset($_POST['PCategoryName'])) {
    $GroupName = $_POST['PCategoryName'];
    $SCondition = "Name = '$GroupName'  ";
    $MenuId2 = $objORM->Fetch($SCondition, 'IdKey', TableIWNewMenu2)->IdKey;

    $SCondition = "GroupIdKey = '$MenuId2'  ";
    echo '<option value="" selected></option>';
    foreach ($objORM->FetchAll($SCondition, 'Name', TableIWNewMenu3) as $ListItem) {
        if ($ListItem->Name == '')
            continue;
        echo '<option value="' . $ListItem->Name . '" >' . $ListItem->Name . '</option>';
    }
}

if (isset($_POST['PGroupName'])) {
    $GroupName = $_POST['PGroupName'];
    $SCondition = "Name = '$GroupName'  ";
    $MenuId2 = $objORM->Fetch($SCondition, 'IdKey', TableIWNewMenu3)->IdKey;

    $SCondition = "GroupIdKey = '$MenuId2'  ";
    echo '<option value="" selected></option>';
    foreach ($objORM->FetchAll($SCondition, 'Name', TableIWNewMenu4) as $ListItem) {
        if ($ListItem->Name == '')
            continue;
        echo '<option value="' . $ListItem->Name . '" >' . $ListItem->Name . '</option>';
    }
}