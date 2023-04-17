<?php
//ClearDB.php

$strExpireDate = date("m-d-Y");
$DCondition = "   ExpireDate < '$strExpireDate'   ";
$objORM->DeleteRow($DCondition, TableIWUserTempCart);

//API Conter
$strExpireDate = date("m-Y");
$SCondition = " ExpireDate = '$strExpireDate' and  CompanyIdKey = '4a897b83' ";
if (!$objORM->DataExist($SCondition, TableIWAPIAllConnect)) {

    $CompanyIdKey = '4a897b83';
    $objTimeTools = new TimeTools();
    $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
    $ModifyTime = $objTimeTools->jdate("H:i:s");
    $ModifyDate = $objTimeTools->jdate("Y/m/d");


    $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;
    $InSet = "";
    $InSet .= " Enabled = '$Enabled' ,";
    $InSet .= " CompanyIdKey = '$CompanyIdKey' ,";
    $InSet .= " Count = 0 ,";
    $InSet .= " ExpireDate = '$strExpireDate' ,";
    $InSet .= " ModifyIP = '$ModifyIP' ,";
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
    $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
    $ModifyTime = $objTimeTools->jdate("H:i:s");
    $ModifyDate = $objTimeTools->jdate("Y/m/d");


    $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;
    $InSet = "";
    $InSet .= " Enabled = '$Enabled' ,";
    $InSet .= " CompanyIdKey = '$CompanyIdKey' ,";
    $InSet .= " Count = 0 ,";
    $InSet .= " ExpireDate = '$strExpireDate' ,";
    $InSet .= " ModifyIP = '$ModifyIP' ,";
    $InSet .= " ModifyTime = '$ModifyTime' ,";
    $InSet .= " ModifyDate = '$ModifyDate' ,";
    $InSet .= " ModifyStrTime = '$ModifyStrTime' ";

    $objORM->DataAdd($InSet, TableIWSMSAllConnect);

}

