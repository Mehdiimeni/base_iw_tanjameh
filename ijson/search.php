<?php
require_once "../icore/vendor/autoload.php";
SessionTools::init();
require_once "../icore/idefine/conf/root.php";
require_once "../icore/idefine/conf/tablename.php";


$objGlobalVar = new GlobalVarTools();
$objFileToolsDBInfo = (new FileTools("../icore/idefine/conf/online.iw"))->KeyValueFileReader();

if ((new IPTools('../icore/idefine/'))->getHostAddressLoad() == 'localhost')
    $objFileToolsDBInfo = (new FileTools("../icore/idefine/conf/local.iw"))->KeyValueFileReader();

$objORM = new DBORM((new MySQLConnection($objFileToolsDBInfo))->getConn());
$objFileToolsInit = new FileTools("../icore/idefine/conf/init.iw");

(new MakeDirectory)->MKDir('../irepository/log/error/', 'iweb', 0755);
$objInitTools = new InitTools($objFileToolsInit->KeyValueFileReader(), '../irepository/log/error/iweb/viewerror.log');

// user profile
$Enabled = true;

$obj_brand = @$objORM->FetchAll("id > 0", 'name', TableIWApiBrands);
$obj_type =  @$objORM->FetchAll("id > 0", 'name', TableIWApiProductType);

$arr_search = array();
foreach($obj_brand as $brand){

    $arr_search[] = $brand->name;

}

foreach($obj_type as $type){

    $arr_search[] = $type->name;

}

echo(json_encode(array_values($arr_search)));

