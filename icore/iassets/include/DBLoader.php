<?php
//DBLoader.php
require dirname(__FILE__, 4) . "/vendor/autoload.php";
SessionTools::init();


require_once dirname(__FILE__, 3) . '/idefine/conf/tablename.php';
require_once dirname(__FILE__, 3) . '/idefine/conf/viewname.php';
require_once dirname(__FILE__, 3) . '/idefine/conf/functionname.php';
require_once dirname(__FILE__, 3) . '/idefine/conf/procedurename.php';

$objGlobalVar = new GlobalVarTools();

$objFileToolsDBInfo = (new FileTools(dirname(__FILE__, 3) . "/idefine/conf/online.iw"))->KeyValueFileReader();

if ((new IPTools(dirname(__FILE__, 3) . "/idefine/"))->getHostAddressLoad() == 'localhost')
    $objFileToolsDBInfo = (new FileTools(dirname(__FILE__, 3) . "/idefine/conf/local.iw"))->KeyValueFileReader();

$objORM = new DBORM((new MySQLConnection($objFileToolsDBInfo))->getConn());