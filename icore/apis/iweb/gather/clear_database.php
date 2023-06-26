<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


require "../../../../vendor/autoload.php";
SessionTools::init();

include "../../../iassets/include/DBLoader.php";

$strExpireDate = date("m-d-Y");
$DCondition = "   ExpireDate < '$strExpireDate'   ";
$objORM->DeleteRow($DCondition, TableIWUserTempCart);

//API Conter
$strExpireDate = date("m-Y");
$SCondition = " ExpireDate = '$strExpireDate' and  CompanyIdKey = '4a897b83' ";
if (!$objORM->DataExist($SCondition, TableIWAPIAllConnect)) {

    $CompanyIdKey = '4a897b83';
    $objTimeTools = new TimeTools();
    $ModifyTime = $objTimeTools->jdate("H:i:s");
    $ModifyDate = $objTimeTools->jdate("Y/m/d");

    $ModifyStrTime = json_decode($objTimeTools->getDateTimeNow())->date;
    $InSet = "";
    $InSet .= " Enabled = 1 ,";
    $InSet .= " CompanyIdKey = '$CompanyIdKey' ,";
    $InSet .= " Count = 0 ,";
    $InSet .= " ExpireDate = '$strExpireDate' ,";
    $InSet .= " ModifyTime = '$ModifyTime' ,";
    $InSet .= " ModifyDate = '$ModifyDate' ,";
    $InSet .= " ModifyStrTime = '$ModifyStrTime' ";

    $objORM->DataAdd($InSet, TableIWAPIAllConnect);

}


//SMS Conter
$strExpireDate = date("m-Y");
$SCondition = " ExpireDate = '$strExpireDate' and  CompanyIdKey = 'e45fef12' ";
if (!$objORM->DataExist($SCondition, TableIWSMSAllConnect)) {

    $CompanyIdKey = 'e45fef12';
    $objTimeTools = new TimeTools();
    $ModifyTime = $objTimeTools->jdate("H:i:s");
    $ModifyDate = $objTimeTools->jdate("Y/m/d");


    $ModifyStrTime = json_decode($objTimeTools->getDateTimeNow())->date;
    $InSet = "";
    $InSet .= " Enabled = 1 ,";
    $InSet .= " CompanyIdKey = '$CompanyIdKey' ,";
    $InSet .= " Count = 0 ,";
    $InSet .= " ExpireDate = '$strExpireDate' ,";
    $InSet .= " ModifyTime = '$ModifyTime' ,";
    $InSet .= " ModifyDate = '$ModifyDate' ,";
    $InSet .= " ModifyStrTime = '$ModifyStrTime' ";

    $objORM->DataAdd($InSet, TableIWSMSAllConnect);

}


echo json_encode('--clear database--');