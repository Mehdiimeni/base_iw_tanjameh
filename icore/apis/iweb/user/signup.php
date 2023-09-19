<?php
require_once "../global/CommonInclude.php";

if (
    !empty($_POST['accept']) and
    !empty($_POST['Name']) and
    !empty($_POST['Email']) and
    !empty($_POST['CellNumber']) and
    !empty($_POST['Fashionpreference']) and
    !empty($_POST['Password'])
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

        $UserSessionId = session_id();
        $SCondition = "  ( iw_user_id = $iw_user_id or session_id = '$UserSessionId'  ) and iw_user_shopping_cart_id != ''  ";
        $intCountAddToCart = $objORM->DataCount($SCondition, TableIWUserTempCart, 'id');


        if ($intCountAddToCart > 0) {

            $stat = true;
            $stat_detials = "20"; // temp cart exist
            $_IWUserId = $iw_user_id; // user id

        } else {
            $stat = true;
            $stat_detials = "21"; // temp cart not exist
            $_IWUserId = $iw_user_id; // user id
        }

    }


} else {

    $stat = false;
    $stat_detials = "12"; // form data have null

}

$arr_signup_user_detials = array(
    'stat' => $stat,
    'stat_detials' => $stat_detials,
    'user_id' => $_IWUserId
);

echo json_encode($arr_signup_user_detials);