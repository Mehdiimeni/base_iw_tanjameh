<?php
require_once "../vendor/autoload.php";
SessionTools::init();
require_once "../idefine/conf/root.php";

(new ConfigTools(IW_DEFINE_FROM_PANEL))->StoperCheck(1);
$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL."conf/init.iw");

(new MakeDirectory)->MKDir(IW_REPOSITORY_FROM_PANEL . 'log/error/', 'ipanel', 0755);
$objInitTools = new InitTools($objFileToolsInit->KeyValueFileReader(), IW_REPOSITORY_FROM_PANEL . 'log/error/ipanel/usererror.log');

(new IWCheckTools((new GlobalVarTools())->GetVarToJson(),IW_DEFINE_FROM_PANEL))->IWKEYShower(IW_DEFINE_FROM_PANEL."conf/key.iw");
new IPTools(IW_DEFINE_FROM_PANEL);

require_once IW_DEFINE_FROM_PANEL."lang/".$objInitTools->getLang().".php";
require_once "user/Entrance.php";

exit();

