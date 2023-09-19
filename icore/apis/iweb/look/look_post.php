<?php
require_once "../global/CommonInclude.php";

if (
    !empty($_POST['image1']) and
    !empty($_POST['image2']) and
    !empty($_POST['image3']) and
    !empty($_POST['image4']) and
    !empty($_POST['look_group']) and
    !empty($_POST['look_gender']) and
    !empty($_POST['user_id'])
) {


    $image1 = $_POST['image1'];
    $image2 = $_POST['image2'];
    $image3 = $_POST['image3'];
    $image4 = $_POST['image4'];
    $itemm1 = empty($_POST['itemm1']) ? 0 : $_POST['itemm1'];
    $iteml1 = empty($_POST['iteml1']) ? 0 : $_POST['iteml1'];
    $itemm2 = empty($_POST['itemm2']) ? 0 : $_POST['itemm2'];
    $iteml2 = empty($_POST['iteml2']) ? 0 : $_POST['iteml2'];
    $itemm3 = empty($_POST['itemm3']) ? 0 : $_POST['itemm3'];
    $iteml3 = empty($_POST['iteml3']) ? 0 : $_POST['iteml3'];
    $itemm4 = empty($_POST['itemm4']) ? 0 : $_POST['itemm4'];
    $iteml4 = empty($_POST['iteml4']) ? 0 : $_POST['iteml4'];


    $look_group = implode(",", $_POST['look_group']);
    $look_gender = implode(",", $_POST['look_gender']);
    $user_id = $objACLTools->CleanStr($_POST['user_id']);
    $post_id = @$objACLTools->CleanStr($_POST['post_id']);


    $objFileToolsInit = new FileTools("../../../idefine/conf/init.iw");
    $objStorageTools = new StorageTools($objFileToolsInit->KeyValueFileReader()['MainName']);
    $objStorageTools->SetRootStoryFile('../../../../irepository/img/');


    $allow_format = array('jpg', 'jpeg', 'png', 'gif', 'webp');

    if ($image1['name'] != null) {

        $FileExt = $objStorageTools->FindFileExt('', $image1['tmp_name']);

        if (!in_array($FileExt, $allow_format)) {

            $stat = false;
            $stat_detials = "14"; // file format error
        }
        if (250 * 1024 * 1024 < filesize($image1['tmp_name'])) {

            $stat = false;
            $stat_detials = "15"; // file format size
        }

        $image1_name = $objStorageTools->FileSetNewName($FileExt);

    }

    if ($image2['name'] != null) {

        $FileExt = $objStorageTools->FindFileExt('', $image2['tmp_name']);

        if (!in_array($FileExt, $allow_format)) {

            $stat = false;
            $stat_detials = "14"; // file format error
        }
        if (250 * 1024 * 1024 < filesize($image2['tmp_name'])) {

            $stat = false;
            $stat_detials = "15"; // file format size
        }

        $image2_name = $objStorageTools->FileSetNewName($FileExt);

    }

    if ($image3['name'] != null) {

        $FileExt = $objStorageTools->FindFileExt('', $image3['tmp_name']);

        if (!in_array($FileExt, $allow_format)) {

            $stat = false;
            $stat_detials = "14"; // file format error
        }
        if (250 * 1024 * 1024 < filesize($image3['tmp_name'])) {

            $stat = false;
            $stat_detials = "15"; // file format size
        }

        $image3_name = $objStorageTools->FileSetNewName($FileExt);

    }

    if ($image4['name'] != null) {

        $FileExt = $objStorageTools->FindFileExt('', $image4['tmp_name']);

        if (!in_array($FileExt, $allow_format)) {

            $stat = false;
            $stat_detials = "14"; // file format error
        }
        if (250 * 1024 * 1024 < filesize($image4['tmp_name'])) {

            $stat = false;
            $stat_detials = "15"; // file format size
        }

        $image4_name = $objStorageTools->FileSetNewName($FileExt);

    }



    $modify_ip = (new IPTools('../../../idefine/'))->getUserIP();



    $Enabled = true;
    $SCondition = " user_id = $user_id and id = $post_id ";

    if (!empty($post_id ) and $objORM->DataExist($SCondition, TableIWUserLookPost, 'id') ) {

        $UpSet = " look_group = '$look_group' ,";
        $UpSet = " look_gender = '$look_gender' ,";
        $UpSet .= " itemm1 = $itemm1 ,";
        $UpSet .= " itemm2 = $itemm2 ,";
        $UpSet .= " itemm3 = $itemm3 ,";
        $UpSet .= " itemm4 = $itemm4 ,";
        $UpSet .= " iteml1 = $iteml1 ,";
        $UpSet .= " iteml2 = $iteml2 ,";
        $UpSet .= " iteml3 = $iteml3 ,";
        $UpSet .= " iteml4 = $iteml4 ,";
        $UpSet .= " stat = 0, ";
        $UpSet .= " modify_ip = '$modify_ip' ";

        if (!empty($image1['tmp_name'])) {

            $UpSet .= " , image1 = '$image1_name' ";
            $objStorageTools->FileCopyServer($image1['tmp_name'], 'look_page_post', $image1_name);
        }

        if (!empty($image2['tmp_name'])) {

            $UpSet .= " , image2 = '$image2_name' ";
            $objStorageTools->FileCopyServer($image2['tmp_name'], 'look_page_post', $image2_name);
        }

        if (!empty($image3['tmp_name'])) {

            $UpSet .= " , image3 = '$image3_name' ";
            $objStorageTools->FileCopyServer($image3['tmp_name'], 'look_page_post', $image3_name);
        }

        if (!empty($image4['tmp_name'])) {

            $UpSet .= " , image4 = '$image4_name' ";
            $objStorageTools->FileCopyServer($image4['tmp_name'], 'look_page_post', $image4_name);
        }


        $objORM->DataUpdate("user_id = $user_id ", $UpSet, TableIWUserLookPost);
        $stat = true;
        $stat_detials = "20"; // look documents add



    } else {


        $InSet = " user_id = $user_id ,";
        $InSet .= " look_group = '$look_group' ,";
        $InSet .= " look_gender = '$look_gender' ,";
        $InSet .= " image1 = '$image1_name' ,";
        $InSet .= " image2 = '$image2_name' ,";
        $InSet .= " image3 = '$image3_name' ,";
        $InSet .= " image4 = '$image4_name' ,";
        $InSet .= " itemm1 = $itemm1 ,";
        $InSet .= " itemm2 = $itemm2 ,";
        $InSet .= " itemm3 = $itemm3 ,";
        $InSet .= " itemm4 = $itemm4 ,";
        $InSet .= " iteml1 = $iteml1 ,";
        $InSet .= " iteml2 = $iteml2 ,";
        $InSet .= " iteml3 = $iteml3 ,";
        $InSet .= " iteml4 = $iteml4 ,";
        $InSet .= " stat = 0, ";
        $InSet .= " modify_ip = '$modify_ip' ";

        if ($objORM->DataAdd($InSet, TableIWUserLookPost)) {

            $objStorageTools->FileCopyServer($image1['tmp_name'], 'look_page_post', $image1_name);
            $objStorageTools->FileCopyServer($image2['tmp_name'], 'look_page_post', $image2_name);
            $objStorageTools->FileCopyServer($image3['tmp_name'], 'look_page_post', $image3_name);
            $objStorageTools->FileCopyServer($image4['tmp_name'], 'look_page_post', $image4_name);

            $stat = true;
            $stat_detials = "20"; // look documents add

        }

    }


} else {

    $stat = false;
    $stat_detials = "12"; // form data have null

}

$arr_post_look_user_detials = array(
    'stat' => $stat,
    'stat_detials' => $stat_detials,
);

echo json_encode($arr_post_look_user_detials);