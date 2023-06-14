<?php
//DBLoader.php

require "../icore/vendor/autoload.php";
SessionTools::init();


require_once  "../icore/idefine/conf/tablename.php";
require_once  "../icore/idefine/conf/viewname.php";
require_once  "../icore/idefine/conf/functionname.php";
require_once  "../icore/idefine/conf/procedurename.php";

$objGlobalVar = new GlobalVarTools();

$objFileToolsDBInfo = (new FileTools("../icore/idefine/conf/online.iw"))->KeyValueFileReader();



if ((new IPTools("../icore/idefine/"))->getHostAddressLoad() == "localhost")
    $objFileToolsDBInfo = (new FileTools("../icore/idefine/conf/local.iw"))->KeyValueFileReader();

$objORM = new DBORM((new MySQLConnection($objFileToolsDBInfo))->getConn());


$objACLTools = new ACLTools();