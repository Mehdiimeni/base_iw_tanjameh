<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../../iassets/include/DBLoader.php";
$objFileToolsDBInfo = db_info();
$objORM = db_orm($objFileToolsDBInfo);

if (
    !empty($_POST['look_page_name']) and
    !empty($_POST['look_page_description']) and
    !empty($_POST['look_page_color']) and
    !empty($_POST['user_id'])
) {


    $look_page_name = $_POST['look_page_name'];
    $look_page_description = $_POST['look_page_description'];
    $look_page_color = $_POST['look_page_color'];

    !isset($_POST['closet']) ? $closet = 0 : $closet = $_POST['closet'];

    $user_id = $objACLTools->CleanStr($_POST['user_id']);


    $objFileToolsInit = new FileTools("../../../idefine/conf/init.iw");
    $objStorageTools = new StorageTools($objFileToolsInit->KeyValueFileReader()['MainName']);
    $objStorageTools->SetRootStoryFile('../../../../irepository/img/');


    $allow_format = array('jpg', 'jpeg', 'png', 'gif', 'webp');

    if ($_POST['look_page_profile']['name'] != null) {

        $FileExt = $objStorageTools->FindFileExt('', $_POST['look_page_profile']['tmp_name']);

        if (!in_array($FileExt, $allow_format)) {

            $stat = false;
            $stat_detials = "14"; // file format error
        }
        if (250 * 1024 * 1024 < filesize($_POST['look_page_profile']['tmp_name'])) {

            $stat = false;
            $stat_detials = "15"; // file format size
        }

        $look_page_profile_name = $objStorageTools->FileSetNewName($FileExt);

    }

    if ($_POST['look_page_banner']['name'] != null) {

        $FileExt = $objStorageTools->FindFileExt('', $_POST['look_page_banner']['tmp_name']);
        if (!in_array($FileExt, $allow_format)) {

            $stat = false;
            $stat_detials = "14"; // file format error
        }
        if (250 * 1024 * 1024 < filesize($_POST['look_page_banner']['tmp_name'])) {

            $stat = false;
            $stat_detials = "15"; // file format size
        }

        $look_page_banner_name = $objStorageTools->FileSetNewName($FileExt);

    }

    $modify_ip = (new IPTools('../../../idefine/'))->getUserIP();



    $Enabled = true;
    $SCondition = " user_id = $user_id ";

    if ($objORM->DataExist($SCondition, TableIWUserLookPage, 'id')) {


        $UpSet = " look_page_name = '$look_page_name' ,";
        $UpSet .= " look_page_description = '$look_page_description' ,";
        $UpSet .= " look_page_color = '$look_page_color', ";
        $UpSet .= " stat = 0, ";
        $UpSet .= " closet = $closet , ";
        $UpSet .= " modify_ip = '$modify_ip' ";

        if (!empty($_POST['look_page_profile']['tmp_name'])) {

            $UpSet .= " , look_page_profile = '$look_page_profile_name' ";
            $objStorageTools->FileCopyServer($_POST['look_page_profile']['tmp_name'], 'look_page', $look_page_profile_name);
        }
        if (!empty($_POST['look_page_banner']['tmp_name'])) {
            $UpSet .= " , look_page_banner = '$look_page_banner_name' ";
            $objStorageTools->FileCopyServer($_POST['look_page_banner']['tmp_name'], 'look_page', $look_page_banner_name);
        }

        $objORM->DataUpdate("user_id = $user_id ", $UpSet, TableIWUserLookPage);
        $stat = true;
        $stat_detials = "20"; // look documents add



    } else {


        $InSet = " user_id = $user_id ,";
        $InSet .= " look_page_name = '$look_page_name' ,";
        $InSet .= " look_page_description = '$look_page_description' ,";
        $InSet .= " look_page_color = '$look_page_color', ";
        $InSet .= " look_page_profile = '$look_page_profile_name', ";
        $InSet .= " look_page_banner = '$look_page_banner_name', ";
        $InSet .= " stat = 0, ";
        $InSet .= " closet = $closet , ";
        $InSet .= " modify_ip = '$modify_ip' ";

        if ($objORM->DataAdd($InSet, TableIWUserLookPage)) {

            $objStorageTools->FileCopyServer($_POST['look_page_profile']['tmp_name'], 'look_page', $look_page_profile_name);
            $objStorageTools->FileCopyServer($_POST['look_page_banner']['tmp_name'], 'look_page', $look_page_banner_name);

            $stat = true;
            $stat_detials = "20"; // look documents add

        }

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