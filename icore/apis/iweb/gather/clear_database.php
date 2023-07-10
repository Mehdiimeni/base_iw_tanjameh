<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include "../../../iassets/include/DBLoader.php";

$expire_date = date("m-d-Y");
$DCondition = "   expire_date < '$expire_date'   ";
$objORM->DeleteRow($DCondition, TableIWUserTempCart);

//API Conter
$expire_date = date("m-Y");
$SCondition = " expire_date = '$expire_date' and  iw_company_id = $obj_product->iw_company_id ";
if (!$objORM->DataExist($SCondition, TableIWAPIAllConnect)) {

    $iw_company_id = $obj_product->iw_company_id;
    $objTimeTools = new TimeTools();
    
    

    $ModifyStrTime = json_decode($objTimeTools->getDateTimeNow())->date;
    $InSet = "";
    $InSet .= " Enabled = 1 ,";
    $InSet .= " iw_company_id = '$iw_company_id' ,";
    $InSet .= " Count = 0 ,";
    $InSet .= " expire_date = '$expire_date' ,";
    
    
    $InSet .= " last_modify = '$now_modify' ";

    $objORM->DataAdd($InSet, TableIWAPIAllConnect);

}


//SMS Conter
$expire_date = date("m-Y");
$SCondition = " expire_date = '$expire_date' and  iw_company_id = 'e45fef12' ";
if (!$objORM->DataExist($SCondition, TableIWSMSAllConnect)) {

    $iw_company_id = 'e45fef12';
    $objTimeTools = new TimeTools();
    
    


    $ModifyStrTime = json_decode($objTimeTools->getDateTimeNow())->date;
    $InSet = "";
    $InSet .= " Enabled = 1 ,";
    $InSet .= " iw_company_id = '$iw_company_id' ,";
    $InSet .= " Count = 0 ,";
    $InSet .= " expire_date = '$expire_date' ,";
    
    
    $InSet .= " last_modify = '$now_modify' ";

    $objORM->DataAdd($InSet, TableIWSMSAllConnect);

}


echo json_encode('--clear database--');