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

    $look_id = $objACLTools->CleanStr($_POST['look_id']);

    if ($objORM->DataExist(" id = $look_id  and enabled = 1 and stat = 1", TableIWUserLookPage)) {

        $obj_look_page = $objORM->Fetch(" id = $look_id ", "*", TableIWUserLookPage);

        $objFileToolsInit = new FileTools("../../../idefine/conf/init.iw");
        $objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
        $objShowFile->SetRootStoryFile('./irepository/img/');


        $look_page_profile = $objShowFile->image_address_edit('../../../../', $objShowFile->FileLocation("look_page"), $obj_look_page->look_page_profile, $obj_look_page->look_page_name, 120, '', '');
        $look_page_profile = str_replace('../../../../', '', $look_page_profile);

        $look_page_banner = $objShowFile->image_address_edit('../../../../', $objShowFile->FileLocation("look_page"), $obj_look_page->look_page_banner, $obj_look_page->look_page_name, 746, '', '');
        $look_page_banner = str_replace('../../../../', '', $look_page_banner);


        $arr_banner_creator_info_detials = array(
            'stat' => true,
            'look_page_name' => $obj_look_page->look_page_name,
            'look_page_discription' => $obj_look_page->look_page_discription,
            'look_page_color' => $obj_look_page->look_page_color,
            'closet' => $obj_look_page->closet,
            'id' => $obj_look_page->id,
            'user_id' => $obj_look_page->user_id,
            'count_look' => 0,
            'look_page_profile' => $look_page_profile,
            'look_page_banner' => $look_page_banner,
        );
    } else {
        $arr_banner_creator_info_detials = array(
            'stat' => false,
        );
    }


} else {

    $arr_banner_creator_info_detials = array(
        'stat' => false,
    );

}

echo json_encode($arr_banner_creator_info_detials);