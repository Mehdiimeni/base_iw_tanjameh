<?php
//TradeJson.php
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

$GroupIdKey = $_GET['group_id'];
$SCondition = "GroupIdKey = '$GroupIdKey'";
print_r($objGlobalVar->JsonEncode(@$objORM->FetchAll($SCondition, 'Name,IdKey', TableIWTrade)));

