<?php
//ClearDB.php

$expire_date = date("m-d-Y");
$DCondition = "   expire_date < '$expire_date'   ";
$objORM->DeleteRow($DCondition, TableIWUserTempCart);

//API Conter
$expire_date = date("m-Y");
$SCondition = " expire_date = '$expire_date' and  iw_company_id = $obj_product->iw_company_id ";
if (!$objORM->DataExist($SCondition, TableIWAPIAllConnect)) {

    $iw_company_id = $obj_product->iw_company_id;
    $objTimeTools = new TimeTools();
    $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
    
    


    $now_modify = date("Y-m-d H:i:s");
    $InSet = "";
    $InSet .= " Enabled = $Enabled ,";
    $InSet .= " iw_company_id = '$iw_company_id' ,";
    $InSet .= " Count = 0 ,";
    $InSet .= " expire_date = '$expire_date' ,";
    $InSet .= " modify_ip = '$modify_ip' ,";
    
    
    $InSet .= " last_modify = '$now_modify' ";

    $objORM->DataAdd($InSet, TableIWAPIAllConnect);

}


//SMS Conter
$expire_date = date("m-Y");
$SCondition = " expire_date = '$expire_date' and  iw_company_id = 'e45fef12' ";
if (!$objORM->DataExist($SCondition, TableIWSMSAllConnect)) {

    $iw_company_id = 'e45fef12';
    $objTimeTools = new TimeTools();
    $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
    
    


    $now_modify = date("Y-m-d H:i:s");
    $InSet = "";
    $InSet .= " Enabled = $Enabled ,";
    $InSet .= " iw_company_id = '$iw_company_id' ,";
    $InSet .= " Count = 0 ,";
    $InSet .= " expire_date = '$expire_date' ,";
    $InSet .= " modify_ip = '$modify_ip' ,";
    
    
    $InSet .= " last_modify = '$now_modify' ";

    $objORM->DataAdd($InSet, TableIWSMSAllConnect);

}

