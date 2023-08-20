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


    $SCondition = " user_id = $user_id  and enabled = 1 and stat = 1";

    if ($objORM->DataExist($SCondition, TableIWUserLookPage, 'id')) {
        $stat = true;
        $stat_detials = "20"; // data exist
        $admin_comment = null;

    } else {

        $stat = false;
        $stat_detials = "13"; // data not exist
        $admin_comment = $objORM->Fetch(
            "user_id = $user_id and enabled = 1 and stat = 0 and admin_comment is not null",
            "admin_comment",
            TableIWUserLookPage
        )->admin_comment;

    }


} else {

    $stat = false;
    $stat_detials = "12"; // form data have null
    $admin_comment = null;

}

$arr_signup_user_detials = array(
    'stat' => $stat,
    'stat_detials' => $stat_detials,
    'admin_comment' => $admin_comment,
);

echo json_encode($arr_signup_user_detials);