<?php
(new MakeDirectory)->MKDir(IW_REPOSITORY_FROM_PANEL . 'log/login/', 'user', 0755);

$objGlobalVar = new GlobalVarTools();
$UserIdKey = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));
$objACL = new ACLTools();

if($objGlobalVar->JsonDecode($objGlobalVar->ServerVarToJson())->HTTP_HOST == 'localhost')
    error_reporting(E_ALL);

require_once IW_DEFINE_FROM_PANEL.'conf/tablename.php';
require_once IW_DEFINE_FROM_PANEL.'conf/viewname.php';
require_once IW_DEFINE_FROM_PANEL.'conf/functionname.php';
require_once IW_DEFINE_FROM_PANEL.'conf/procedurename.php';

if(@$objACL->NormalUserLogin(IW_REPOSITORY_FROM_PANEL.'log/login/user/'.$UserIdKey))
{
   (new FileCaller)->FileIncluderWithControler(IW_PANEL_FROM_PANEL.'user/','Login','Login');
}else
{
    (new FileCaller)->FileIncluderWithControler(IW_PANEL_FROM_PANEL.'user/','GlobalPage','PageLoader');
}
