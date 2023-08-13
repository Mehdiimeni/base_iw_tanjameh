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

    if ($objORM->DataExist(" user_id = $user_id ", TableIWUserLookPage)) {

        $obj_look_page = $objORM->Fetch(" user_id = $user_id ", "*", TableIWUserLookPage);
        $arr_look_page_info_detials = array(
            'stat' => true,
            'look_page_name' => $obj_look_page->look_page_name,
            'look_page_discription' => $obj_look_page->look_page_discription,
            'look_page_color' => $obj_look_page->look_page_color,
            'closet' => $obj_look_page->closet,
            'id' => $obj_look_page->id,
        );
    } else {
        $arr_look_page_info_detials = array(
            'stat' => false,
        );
    }


} else {

    $arr_look_page_info_detials = array(
        'stat' => false,
    );

}

echo json_encode($arr_look_page_info_detials);