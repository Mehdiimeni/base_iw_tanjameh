<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include "../../../iassets/include/DBLoader.php";
$objFileToolsDBInfo = db_info();
$objORM = db_orm($objFileToolsDBInfo);

if (!empty($_POST['user_id'])) {


    $user_id = $objACLTools->CleanStr($_POST['user_id']);


    $objFileToolsInit = new FileTools("../../../idefine/conf/init.iw");
    $objStorageTools = new StorageTools($objFileToolsInit->KeyValueFileReader()['MainName']);
    $objStorageTools->SetRootStoryFile('../../../../irepository/img/');


    $SCondition = " user_id = $user_id and id_cart_front is not null and id_cart_back is not null and user_face is not null";

    if ($objORM->DataExist($SCondition, TableIWUserLookDocuments, 'id')) {
        $stat = true;
        $stat_detials = "20"; // data exist

    } else {

        $stat = false;
        $stat_detials = "13"; // data not exist

    }


} else {

    $stat = false;
    $stat_detials = "12"; // form data have null

}

$arr_signup_user_detials = array(
    'stat' => $stat,
    'stat_detials' => $stat_detials,
);

echo json_encode($arr_signup_user_detials);