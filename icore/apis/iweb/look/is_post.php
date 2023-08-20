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
    $post_id = $_POST['post_id'];

    $user_id = $objACLTools->CleanStr($_POST['user_id']);

    if ($objORM->DataExist(" user_id = $user_id and  id = $post_id and stat = 0 and enabled = 1 ", TableIWUserLookPost)) {

        $objFileToolsInit = new FileTools("../../../idefine/conf/init.iw");
        $objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
        $objShowFile->SetRootStoryFile('./irepository/img/');

        $obj_user_post = $objORM->Fetch(
            "user_id = $user_id and  id = $post_id and stat = 0 and enabled = 1 ",
            "*",
            TableIWUserLookPost
        );
        $arr_user_post = array();

        $arr_user_post = array(
            'user_id' => $user_id,
            'post_id' => $obj_user_post->id,
            'admin_comment' => $obj_user_post->admin_comment,
        );

        echo json_encode($arr_user_post);

    } else {
        echo false;
    }

} else {
    echo false;
}