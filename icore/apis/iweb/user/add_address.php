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
    !empty($_POST['NicName']) and
    !empty($_POST['gender']) and
    !empty($_POST['name']) and
    !empty($_POST['family']) and
    !empty($_POST['iw_country_id']) and
    !empty($_POST['PostCode']) and
    !empty($_POST['city']) and
    !empty($_POST['user_id']) and
    !empty($_POST['Address'])
) {

    $NicName = $objACLTools->CleanStr($_POST['NicName']);
    $gender = $objACLTools->CleanStr($_POST['gender']);
    $name = $objACLTools->CleanStr($_POST['name']);
    $family = $objACLTools->CleanStr($_POST['family']);
    $iw_country_id = $objACLTools->CleanStr($_POST['iw_country_id']);
    $PostCode = $objACLTools->CleanStr($_POST['PostCode']);
    $OtherTel = $objACLTools->CleanStr($_POST['OtherTel']);
    $city = $objACLTools->CleanStr($_POST['city']);
    $Address = $objACLTools->CleanStr($_POST['Address']);
    $Description = $objACLTools->CleanStr($_POST['Description']);
    $is_default = $objACLTools->CleanStr(@$_POST['is_default']);
    $user_id = $objACLTools->CleanStr($_POST['user_id']);

    $Enabled = true;
    $SCondition = "(
        NicName = '$NicName' and
        gender = '$gender' and
        name = '$name' and
        family = '$family') or
        PostCode = '$PostCode'  
     ";


    if ($objORM->DataExist($SCondition, TableIWUserAddressDetails, 'id')) {
        $stat = false;
        $stat_detials = "15"; // data exist

    } else {

        $modify_ip = (new IPTools('../../../idefine/'))->getUserIP();
        $now_modify = date("Y-m-d H:i:s");



        $InSet = " Enabled = $Enabled ,";
        $InSet .= " NicName = '$NicName' ,";
        $InSet .= " gender = '$gender' ,";
        $InSet .= " name = '$name' ,";
        $InSet .= " family = '$family' ,";
        $InSet .= " iw_country_id = $iw_country_id ,";
        $InSet .= " PostCode = '$PostCode' ,";
        $InSet .= " OtherTel = '$OtherTel' ,";
        $InSet .= " city = '$city' ,";
        $InSet .= " Address = '$Address' ,";
        $InSet .= " Description = '$Description' ,";
        $InSet .= " modify_ip = '$modify_ip', ";
        $InSet .= " modify_id = $user_id ";

        $objORM->DataAdd($InSet, TableIWUserAddressDetails);
        $iw_user_address_details_id = $objORM->LastId();

        ($is_default != '') ? $default = $is_default : $default = 0;

        $InSet = " is_default = $default ,";
        $InSet .= " modify_ip = '$modify_ip' ,";
        $InSet .= " iw_user_address_details_id = $iw_user_address_details_id ,";
        $InSet .= " iw_user_id = $user_id, ";
        $InSet .= " modify_id = $user_id ";

        $objORM->DataAdd($InSet, TableIWUserAddress);


        $stat = true;
        $stat_detials = "22"; // temp cart not exist

    }


} else {

    $stat = false;
    $stat_detials = "14"; // form data have null

}

$arr_address_user_detials = array(
    'stat' => $stat,
    'stat_detials' => $stat_detials
);

echo json_encode($arr_address_user_detials);