<?php
require_once "../global/CommonInclude.php";

if (!empty($_POST['gender']) and !empty($_POST['category']) and !empty($_POST['group']) and $_POST['category'] == 'look') {

    $gender = $_POST['gender'];
    $group = $_POST['group'];

    $arr_user_post = array();

    if ($objORM->DataExist(" look_gender = '$gender'  and enabled = 1 and stat = 1", TableIWUserLookPost)) {

        if ($group != 'All') {
            $look_group = $objORM->Fetch("root = '$group' ", "id,name", TableIWUserLookGroup);
            $obj_look_posts = $objORM->FetchAll(" look_group = $look_group->id and look_gender = '$gender'  and enabled = 1 and stat = 1 ", "*", TableIWUserLookPost);
            $look_group_name = $look_group->name;
        } else {
            $obj_look_posts = $objORM->FetchAll("look_gender = '$gender'  and enabled = 1 and stat = 1 ", "*", TableIWUserLookPost);
            $look_group_name = 'همه';
        }


        $objFileToolsInit = new FileTools("../../../idefine/conf/init.iw");
        $objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
        $objShowFile->SetRootStoryFile('./irepository/img/');



        $total = 0;
        foreach ($obj_look_posts as $all_user_post) {

            $obj_user_page = $objORM->Fetch("user_id = $all_user_post->user_id ", "look_page_name,look_page_profile,id", TableIWUserLookPage);

            $image_one_address = $objShowFile->image_address_edit('../../../../', $objShowFile->FileLocation("look_page_post"), $all_user_post->image1, $obj_user_page->look_page_name, 336, '');
            $image_one_address = str_replace('../../../../', '', $image_one_address);

            $look_page_profile = $objShowFile->image_address_edit('../../../../', $objShowFile->FileLocation("look_page"), $obj_user_page->look_page_profile, $obj_user_page->look_page_name, 120, '', '');
            $look_page_profile = str_replace('../../../../', '', $look_page_profile);
            $total++;

            $arr_user_post[] = array(

                'images_address' => $image_one_address,
                'user_id' => $all_user_post->user_id,
                'look_page_name' => $obj_user_page->look_page_name,
                'look_page_id' => $obj_user_page->id,
                'look_page_profile' => $obj_user_page->look_page_profile,
                'post_id' => $all_user_post->id,
                'group_name' => $look_group_name,
                'total' => $total,
            );
        }

        echo json_encode($arr_user_post);

    } else {
        echo false;
    }

} else {
    echo false;
}