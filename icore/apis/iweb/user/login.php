<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../../iassets/include/DBLoader.php";

if (!empty($_POST['username']) and !empty($_POST['password'])) {


    $UserNameL = $_POST['username'];
    $PasswordL = $objACLTools->mdShal($_POST['password'], 0);

    $Enabled = true;
    $SCondition = "(Email = '$UserNameL' or CellNumber = '$UserNameL'  or NationalCode = '$UserNameL'  ) and Password = '$PasswordL' and Enabled = $Enabled ";

    if (!$objORM->DataExist($SCondition, TableIWUser, 'id')) {

        $stat = false;
        $stat_detials = "11"; // user not exist or disabled

    } else {

        $Online = true;
        $modify_ip = (new IPTools('../../../idefine/'))->getUserIP();
        $now_modify = date("Y-m-d H:i:s");


        $obj_user_info = $objORM->Fetch($SCondition, 'id,iw_user_group_id,Name,CellNumber,NationalCode', TableIWUser);

        $iw_user_group_id = $obj_user_info->iw_user_group_id;
        $UserGroup = $objORM->Fetch("id = '$iw_user_group_id'", 'id,Name', TableIWUserGroup);

        $InSet = "";
        $InSet .= " Online = $Online ,";
        $InSet .= " modify_ip = '$modify_ip' ,";
        $InSet .= " modify_id = $obj_user_info->id  ,";
        $InSet .= " last_modify = '$now_modify', ";
        $InSet .= " iw_user_id = $obj_user_info->id";

        $objORM->DataAdd($InSet, TableIWUserObserver);


        $USet = "CountEnter = CountEnter + '1' ";
        $objORM->DataUpdate($SCondition, $USet, TableIWUser);

        $FOpen = fopen('../../../../irepository/log/login/user/' . $obj_user_info->id . '.iw', 'a+');
        fwrite($FOpen, "$obj_user_info->id==::==$now_modify==::==in\n");
        fclose($FOpen);



        $UserSessionId = session_id();
        $SCondition = "  ( iw_user_id = $obj_user_info->id or session_id = '$UserSessionId'  ) and iw_api_products_id != ''  ";
        $intCountAddToCart = $objORM->DataCount($SCondition, TableIWUserTempCart,'id');


        if ($intCountAddToCart > 0) {

            $stat = true;
            $stat_detials = "20"; // temp cart exist
            $_IWUserId = $obj_user_info->id; // user id

        } else {
            $stat = true;
            $stat_detials = "21"; // temp cart not exist
            $_IWUserId = $obj_user_info->id; // user id
        }


    }



} else {

    $stat = false;
    $stat_detials = "10"; // user or pass null

}

$arr_login_user_detials = array(
    'stat' => $stat,
    'stat_detials' => $stat_detials,
    'user_id' => $_IWUserId
);

echo json_encode($arr_login_user_detials);