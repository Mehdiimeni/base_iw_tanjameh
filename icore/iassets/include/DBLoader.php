<?php
require "../../../vendor/autoload.php";
SessionTools::init();

$includePaths = [
    "../../../idefine/conf/",
];

foreach ($includePaths as $path) {
    foreach (glob($path . "*.php") as $filename) {
        require_once $filename;
    }
}

$objGlobalVar = new GlobalVarTools();
$objACLTools = new ACLTools();

function db_info($db_name = '')
{

    $objFileToolsDBInfo = (new FileTools("../../../idefine/conf/" . $db_name . "online.iw"))->KeyValueFileReader();

    if ((new IPTools("../../../idefine/"))->getHostAddressLoad() == "localhost")
        $objFileToolsDBInfo = (new FileTools("../../../idefine/conf/" . $db_name . "local.iw"))->KeyValueFileReader();


    return $objFileToolsDBInfo;

}

function db_orm($objFileToolsDBInfo)
{
    return new DBORM((new MySQLConnection($objFileToolsDBInfo))->getConn());
}