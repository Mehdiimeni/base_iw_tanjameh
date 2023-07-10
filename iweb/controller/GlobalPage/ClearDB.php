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
    $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
    
    


    $now_modify = date("Y-m-d H:i:s");
    $InSet = "";
    $InSet .= " Enabled = $Enabled ,";
    $InSet .= " CompanyIdKey = '$CompanyIdKey' ,";
    $InSet .= " Count = 0 ,";
    $InSet .= " ExpireDate = '$strExpireDate' ,";
    $InSet .= " modify_ip = '$modify_ip' ,";
    
    
    $InSet .= " last_modify = '$now_modify' ";

    $objORM->DataAdd($InSet, TableIWAPIAllConnect);

}


//SMS Conter
$strExpireDate = date("m-Y");
$SCondition = " ExpireDate = '$strExpireDate' and  CompanyIdKey = 'e45fef12' ";
if (!$objORM->DataExist($SCondition, TableIWSMSAllConnect)) {

    $CompanyIdKey = 'e45fef12';
    $objTimeTools = new TimeTools();
    $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
    
    


    $now_modify = date("Y-m-d H:i:s");
    $InSet = "";
    $InSet .= " Enabled = $Enabled ,";
    $InSet .= " CompanyIdKey = '$CompanyIdKey' ,";
    $InSet .= " Count = 0 ,";
    $InSet .= " ExpireDate = '$strExpireDate' ,";
    $InSet .= " modify_ip = '$modify_ip' ,";
    
    
    $InSet .= " last_modify = '$now_modify' ";

    $objORM->DataAdd($InSet, TableIWSMSAllConnect);

}

