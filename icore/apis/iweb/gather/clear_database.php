<?php 
require_once "../global/CommonInclude.php";


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