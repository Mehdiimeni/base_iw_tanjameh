<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include "../../../iassets/include/DBLoader.php";


$iw_company_id = $_POST['iw_company_id'];
$now_modify = date("Y-m-d H:i:s");

//API Conter
$expire_date = date("m-Y");
$SCondition = " expire_date = '$expire_date' and  iw_company_id = $iw_company_id ";
if (!$objORM->DataExist($SCondition, TableIWAPIAllConnect, 'id')) {

    $objTimeTools = new TimeTools();

    $InSet = " Enabled = 1 ,";
    $InSet .= " iw_company_id = $iw_company_id ,";
    $InSet .= " all_count = 0 ,";
    $InSet .= " expire_date = '$expire_date' ";

    $objORM->DataAdd($InSet, TableIWAPIAllConnect);

}


//SMS Conter
$expire_date = date("m-Y");
$SCondition = " expire_date = '$expire_date' and  iw_company_id = $iw_company_id ";
if (!$objORM->DataExist($SCondition, TableIWSMSAllConnect, 'id')) {

    $InSet = " Enabled = 1 ,";
    $InSet .= " iw_company_id = $iw_company_id ,";
    $InSet .= " all_count = 0 ,";
    $InSet .= " expire_date = '$expire_date' ";

    $objORM->DataAdd($InSet, TableIWSMSAllConnect);

}


echo json_encode('--clear database--');