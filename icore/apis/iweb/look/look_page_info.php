<?php
require_once "../global/CommonInclude.php";


if (!empty($_POST['user_id'])) {



    $user_id = $_POST['user_id'];



    if ($objORM->DataExist(" user_id = $user_id ", TableIWUserLookPage)) {

        $obj_look_page = $objORM->Fetch(" user_id = $user_id ", "*", TableIWUserLookPage);
        $arr_look_page_info_detials = array(
            'stat' => true,
            'look_page_name' => $obj_look_page->look_page_name,
            'look_page_description' => $obj_look_page->look_page_description,
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