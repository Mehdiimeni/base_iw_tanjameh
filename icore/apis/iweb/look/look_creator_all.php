<?php
require_once "../global/CommonInclude.php";

if (!empty($_POST['user_id'])) {

    $user_id = $objACLTools->CleanStr($_POST['user_id']);

    $objFileToolsInit = new FileTools("../../../idefine/conf/init.iw");
    $objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
    $objShowFile->SetRootStoryFile('./irepository/img/');


    $obj_all_user_post = $objORM->FetchAll(
        "user_id = $user_id limit 30",
        "*",
        TableIWUserLookPost
    );
    $arr_user_post = array();



    foreach ($obj_all_user_post as $all_user_post) {

        $image_one_address = $objShowFile->image_address_edit('../../../../', $objShowFile->FileLocation("look_page_post"), $all_user_post->image1, $user_id, 120, '');
        $image_one_address = str_replace('../../../../', '', $image_one_address);

        $arr_user_post[] = array(
            'images_address' => $image_one_address,
            'user_id' => $user_id,
            'post_id' => $all_user_post->id,
            'admin_comment' => $all_user_post->admin_comment,
        );
    }

    echo json_encode($arr_user_post);

} else {
    echo false;
}