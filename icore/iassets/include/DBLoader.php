<?php
//DBLoader.php

require "../../../vendor/autoload.php";
SessionTools::init();


require_once "../../../idefine/conf/tablename.php";
require_once "../../../idefine/conf/viewname.php";
require_once "../../../idefine/conf/functionname.php";
require_once "../../../idefine/conf/procedurename.php";


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