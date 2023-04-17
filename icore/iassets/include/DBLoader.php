<?php
//DBLoader.php
$objGlobalVar = new GlobalVarTools();



//$_Icore_Root = (new Router())->icore(dirname(__FILE__, 3));


$objFileToolsDBInfo = (new FileTools( "../icore/idefine/conf/online.iw"))->KeyValueFileReader();

if ((new IPTools( "../icore/idefine/"))->getHostAddressLoad() == 'localhost')
    $objFileToolsDBInfo = (new FileTools( "../icore/idefine/conf/local.iw"))->KeyValueFileReader();

$objORM = new DBORM((new MySQLConnection($objFileToolsDBInfo))->getConn());

