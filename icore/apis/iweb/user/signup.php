<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../../iassets/include/DBLoader.php";

if (
    isset($_POST['accept']) and
    isset($_POST['Name']) and
    isset($_POST['Email']) and
    isset($_POST['CellNumber']) and
    isset($_POST['Fashionpreference']) and
    isset($_POST['Password'])
) {


    $Name = $objACLTools->CleanStr($_POST['Name']);
    $Email = $objACLTools->CleanStr($_POST['Email']);
    $CellNumber = $objACLTools->CleanStr($_POST['CellNumber']);
    $Fashionpreference = $objACLTools->CleanStr($_POST['Fashionpreference']);
    $PasswordL = $objACLTools->mdShal($_POST['Password'], 1);

    $Enabled = true;
    $SCondition = " Email = '$Email' OR CellNumber = '$CellNumber'  ";


    if ($objORM->DataExist($SCondition, TableIWUser, 'id')) {
        $stat = false;
        $stat_detials = "13"; // data exist

    } else {

        $modify_ip = (new IPTools('../../../idefine/'))->getUserIP();
        $now_modify = date("Y-m-d H:i:s");

        $iw_user_group_id = $objORM->Fetch("Name = 'normal' ", "id", TableIWUserGroup)->id;

        $InSet = "";
        $InSet .= " Enabled = $Enabled ,";
        $InSet .= " Name = '$Name' ,";
        $InSet .= " Email = '$Email' ,";
        $InSet .= " CellNumber = '$CellNumber' ,";
        $InSet .= " Image = 'No Image' ,";
        $InSet .= " CountEnter = 1 ,";
        $InSet .= " pre_refrence = '$Fashionpreference' ,";
        $InSet .= " Password = '$PasswordL' ,";
        $InSet .= " modify_ip = '$modify_ip' ,";
        $InSet .= " iw_user_group_id = $iw_user_group_id ";

        $objORM->DataAdd($InSet, TableIWUser);
        $iw_user_id = $objORM->LastId();

        $Online = true;
        $InSet = "";
        $InSet .= " Online = $Online ,";
        $InSet .= " modify_ip = '$modify_ip' ,";
        $InSet .= " iw_user_id = $iw_user_id ";

        $objORM->DataAdd($InSet, TableIWUserObserver);

        $FOpen = fopen('../../../../irepository/log/login/user/' . $iw_user_id . '.iw', 'a+');
        fwrite($FOpen, "$iw_user_id==::==$now_modify==::==in\n");
        fclose($FOpen);

        $objGlobalVar->setSessionVar('_IWUserId', $iw_user_id);
        $objGlobalVar->setCookieVar('_IWUserId', $objACLTools->en2Base64($iw_user_id, 1));

        $UserSessionId = session_id();
        $SCondition = "  ( iw_user_id = $iw_user_id or session_id = '$UserSessionId'  ) and iw_api_product_variants_id != ''  ";
        $intCountAddToCart = $objORM->DataCount($SCondition, TableIWUserTempCart, 'id');


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
    $stat_detials = "12"; // form data have null

}

$arr_signup_user_detials = array(
    'stat' => $stat,
    'stat_detials' => $stat_detials
);

echo json_encode($arr_signup_user_detials);