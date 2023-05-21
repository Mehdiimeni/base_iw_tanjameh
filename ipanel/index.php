<?php
require_once "../vendor/autoload.php";
SessionTools::init();
require_once "../icore/idefine/conf/root.php";

(new ConfigTools(IW_DEFINE_FROM_PANEL))->StoperCheck(1);
$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL."conf/init.iw");

(new MakeDirectory)->MKDir(dirname(__FILE__, 1) . '/irepository/log/error/', 'ipanel', 0755);
$objInitTools = new InitTools($objFileToolsInit->KeyValueFileReader(), dirname(__FILE__, 1) . '/irepository/log/error/ipanel/adminerror.log');

(new IWCheckTools((new GlobalVarTools())->GetVarToJson(),IW_DEFINE_FROM_PANEL))->IWKEYShower(IW_DEFINE_FROM_PANEL."conf/key.iw");
new IPTools(IW_DEFINE_FROM_PANEL);

require_once IW_DEFINE_FROM_PANEL."lang/".$objInitTools->getLang().".php";
require_once "admin/Entrance.php";

exit();

