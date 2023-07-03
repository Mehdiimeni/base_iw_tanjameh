<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../../iassets/include/DBLoader.php";

if (isset($_POST['UserNameL']) and isset($_POST['PasswordL'])) {


    $UserNameL = $objACLTools->JsonDecode($objACLTools->PostVarToJson())->UserNameL;
    $PasswordL = $objACLTools->mdShal($objACLTools->JsonDecode($objACLTools->PostVarToJson())->PasswordL, 0);

    $Enabled = true;
    $SCondition = "(Email = '$UserNameL' or CellNumber = '$UserNameL'  or NationalCode = '$UserNameL'  ) and Password = '$PasswordL' and Enabled = '$Enabled' ";

    if (!$objORM->DataExist($SCondition, TableIWUser)) {

        $stat = false;
        $stat_detials = "12"; // user not exist or disabled

    } else {

        $Online = true;
        $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
        $now_modify = date("Y-m-d H:i:s");


        $obj_user_info = $objORM->Fetch($SCondition, 'id,iw_user_group_id,Name,CellNumber,NationalCode', TableIWUser);

        $iw_user_group_id = $obj_user_info->iw_user_group_id;
        $UserGroup = $objORM->Fetch("id = '$iw_user_group_id'", 'id,Name', TableIWUserGroup);

        $InSet = "";
        $InSet .= " Online = '$Online' ,";
        $InSet .= " modify_ip = '$modify_ip' ,";
        $InSet .= " modify_id = $obj_user_info->id  ,";
        $InSet .= " last_modify = '$now_modify' ";

        $objORM->DataAdd($InSet, TableIWUserObserver);


        $USet = "CountEnter = CountEnter + '1' ";
        $objORM->DataUpdate($SCondition, $USet, TableIWUser);

        $FOpen = fopen('../../../../irepository/log/login/user/' . $obj_user_info->id . '.iw', 'a+');
        fwrite($FOpen, "$obj_user_info->id==::==$now_modify==::==in\n");
        fclose($FOpen);

        $objGlobalVar->setSessionVar('_IWUserIdKey', $obj_user_info->id);
        $objGlobalVar->setCookieVar('_IWUserIdKey', $objACLTools->en2Base64($obj_user_info->id, 1));


        $UserSessionId = session_id();
        $SCondition = "  ( iw_user_id = $obj_user_info->id or UserSessionId = '$UserSessionId'  ) and ProductId != ''  ";
        $intCountAddToCart = $objORM->DataCount($SCondition, TableIWUserTempCart);


        if ($intCountAddToCart > 0) {

            $stat = true;
            $stat_detials = "20"; // temp cart exist

        } else {
            $stat = true;
            $stat_detials = "21"; // temp cart not exist
        }


    }



} else {

    $stat = false;
    $stat_detials = "11"; // user or pass null

}

$arr_login_user_detials = array(
    'stat' => $stat,
    'total_en' => $stat_detials
);

echo json_encode($arr_login_user_detials);