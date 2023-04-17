<?php
(new MakeDirectory)->MKDir(IW_REPOSITORY_FROM_PANEL . 'log/login/', 'admin', 0755);

$objGlobalVar = new GlobalVarTools();
isset($_REQUEST['_IWAdminIdKey']) ? $AdminIdKey = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminIdKey')) : $AdminIdKey = null;
$objACL = new ACLTools();

if($objGlobalVar->JsonDecode($objGlobalVar->ServerVarToJson())->HTTP_HOST == 'localhost')
    error_reporting(E_ALL);

require_once IW_DEFINE_FROM_PANEL.'conf/tablename.php';
require_once IW_DEFINE_FROM_PANEL.'conf/viewname.php';
require_once IW_DEFINE_FROM_PANEL.'conf/functionname.php';
require_once IW_DEFINE_FROM_PANEL.'conf/procedurename.php';


if(@$objACL->NormalLogin(IW_REPOSITORY_FROM_PANEL.'log/login/admin/'.$AdminIdKey))
{

   (new FileCaller)->FileIncluderWithControler(IW_PANEL_FROM_PANEL.'admin/','Login','Login');
}else
{
    (new FileCaller)->FileIncluderWithControler(IW_PANEL_FROM_PANEL.'admin/','GlobalPage','PageLoader');
}
