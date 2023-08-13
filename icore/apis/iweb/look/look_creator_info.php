<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../../iassets/include/DBLoader.php";
$objFileToolsDBInfo = db_info();
$objORM = db_orm($objFileToolsDBInfo);

if (!empty($_POST['look_id'])) {

    $look_id = $_POST['look_id'];

    if ($objORM->DataExist(" id = $look_id  and enabled = 1 and stat = 1", TableIWUserLookPage)) {

        $obj_look_page = $objORM->Fetch(" id = $look_id ", "user_id,look_page_name", TableIWUserLookPage);

        $objFileToolsInit = new FileTools("../../../idefine/conf/init.iw");
        $objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
        $objShowFile->SetRootStoryFile('./irepository/img/');


        $obj_all_user_post = $objORM->FetchAll(
            "user_id = $obj_look_page->user_id limit 30",
            "*",
            TableIWUserLookPost
        );
        $arr_user_post = array();



        foreach ($obj_all_user_post as $all_user_post) {

            $image_one_address = $objShowFile->image_address_edit('../../../../', $objShowFile->FileLocation("look_page_post"), $all_user_post->image1, $obj_look_page->look_page_name, 336, '');
            $image_one_address = str_replace('../../../../', '', $image_one_address);


            $arr_user_post[] = array(

                'images_address' => $image_one_address,
                'user_id' => $obj_look_page->user_id,
                'look_page_name' => $obj_look_page->look_page_name,
                'post_id' => $all_user_post->id,
            );
        }

        echo json_encode($arr_user_post);

    } else {
        echo false;
    }

} else {
    echo false;
}