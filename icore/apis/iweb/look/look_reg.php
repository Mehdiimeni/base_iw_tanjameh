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
    !empty($_POST['id_cart_front']) and
    !empty($_POST['id_cart_back']) and
    !empty($_POST['user_face']) and
    !empty($_POST['user_id'])
) {


    $user_id = $objACLTools->CleanStr($_POST['user_id']);


    $objFileToolsInit = new FileTools("../../../idefine/conf/init.iw");
    $objStorageTools = new StorageTools($objFileToolsInit->KeyValueFileReader()['MainName']);
    $objStorageTools->SetRootStoryFile('../../../../irepository/img/');


    $Enabled = true;
    $SCondition = " user_id = $user_id and id_cart_front is not null and id_cart_back is not null and user_face is not null";


    if ($objORM->DataExist($SCondition, TableIWUserLookDocuments, 'id')) {
        $stat = false;
        $stat_detials = "13"; // data exist

    } else {

        $allow_format = array('jpg', 'jpeg', 'png', 'gif', 'webp');

        if ($_POST['id_cart_front']['name'] != null) {

            $FileExt = $objStorageTools->FindFileExt('', $_POST['id_cart_front']['tmp_name']);

            if (!in_array($FileExt, $allow_format)) {

                $stat = false;
                $stat_detials = "14"; // file format error
            }
            if (250 * 1024 * 1024 < filesize($_POST['user_face']['tmp_name'])) {

                $stat = false;
                $stat_detials = "15"; // file format size
            }

            $cart_front_name = $objStorageTools->FileSetNewName($FileExt);

        }

        if ($_POST['id_cart_back']['name'] != null) {

            $FileExt = $objStorageTools->FindFileExt('', $_POST['id_cart_back']['tmp_name']);
            if (!in_array($FileExt, $allow_format)) {

                $stat = false;
                $stat_detials = "14"; // file format error
            }
            if (250 * 1024 * 1024 < filesize($_POST['user_face']['tmp_name'])) {

                $stat = false;
                $stat_detials = "15"; // file format size
            }

            $cart_back_name = $objStorageTools->FileSetNewName($FileExt);

        }


        if ($_POST['user_face']['name'] != null) {

            $FileExt = $objStorageTools->FindFileExt('', $_POST['user_face']['tmp_name']);
            if (!in_array($FileExt, $allow_format)) {

                $stat = false;
                $stat_detials = "14"; // file format error
            }
            if (250 * 1024 * 1024 < filesize($_POST['user_face']['tmp_name'])) {

                $stat = false;
                $stat_detials = "15"; // file format size
            }

            $user_face_name = $objStorageTools->FileSetNewName($FileExt);

        }

        $modify_ip = (new IPTools('../../../idefine/'))->getUserIP();

        $InSet = "";
        $InSet .= " user_id = $user_id ,";
        $InSet .= " id_cart_front = '$cart_front_name' ,";
        $InSet .= " id_cart_back = '$cart_back_name' ,";
        $InSet .= " user_face = '$user_face_name', ";
        $InSet .= " stat = 0, ";
        $InSet .= " modify_ip = '$modify_ip' ";

        if ($objORM->DataAdd($InSet, TableIWUserLookDocuments)) {

            $objStorageTools->FileCopyServer($_POST['id_cart_front']['tmp_name'], 'user_look', $cart_front_name);
            $objStorageTools->FileCopyServer($_POST['id_cart_back']['tmp_name'], 'user_look', $cart_back_name);
            $objStorageTools->FileCopyServer($_POST['user_face']['tmp_name'], 'user_look', $user_face_name);

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