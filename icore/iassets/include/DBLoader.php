<?php
//DBLoader.php

require "../../../vendor/autoload.php";
SessionTools::init();


require_once  "../../../idefine/conf/tablename.php";
require_once  "../../../idefine/conf/viewname.php";
require_once  "../../../idefine/conf/functionname.php";
require_once  "../../../idefine/conf/procedurename.php";

$objGlobalVar = new GlobalVarTools();

$objFileToolsDBInfo = (new FileTools("../../../idefine/conf/online.iw"))->KeyValueFileReader();



if ((new IPTools("../../../idefine/"))->getHostAddressLoad() == "localhost")
    $objFileToolsDBInfo = (new FileTools("../../../idefine/conf/local.iw"))->KeyValueFileReader();

$objORM = new DBORM((new MySQLConnection($objFileToolsDBInfo))->getConn());


$objACLTools = new ACLTools();