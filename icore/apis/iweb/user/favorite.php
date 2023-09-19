<?php
require_once "../global/CommonInclude.php";

if (
    !empty($_POST['item_id']) and
    !empty($_POST['company_id'])
) {

    $item_id = $objACLTools->CleanStr($_POST['item_id']);
    $session_id = $objACLTools->CleanStr($_POST['session_id']);
    $company_id = $objACLTools->CleanStr($_POST['company_id']);
    !empty($_POST['look_id']) ? $look_id = $objACLTools->CleanStr(@$_POST['look_id']) : $look_id = 0;
    !empty($_POST['lounge_id']) ? $lounge_id = $objACLTools->CleanStr(@$_POST['lounge_id']) : $lounge_id = 0;
    !empty($_POST['user_id']) ? $user_id = $objACLTools->CleanStr(@$_POST['user_id']) : $user_id = 0;


    $SCondition = "(user_id = $user_id or session_id = '$session_id') and  item_id = $item_id  ";

    if (!$objORM->DataExist($SCondition, TableIWUserFavorite)) {

        $count_fav = $objORM->DataCount($SCondition, TableIWUserFavorite);

        if ($count_fav > 29) {
            $objORM->DeleteRow("user_id = $user_id or session_id = '$session_id' order by id limit 1", TableIWUserFavorite);
        }


        $InSet = " user_id = $user_id ,";
        $InSet .= " item_id = $item_id ,";
        $InSet .= " company_id = $company_id ,";
        $InSet .= " look_id = $look_id ,";
        $InSet .= " lounge_id = $lounge_id ,";
        $InSet .= " session_id = '$session_id' ";

        $objORM->DataAdd($InSet, TableIWUserFavorite);

    }

    $response = array(
        "success" => true,
        "fav_count" => $objORM->DataCount("(user_id = $user_id or session_id = '$session_id')", TableIWUserFavorite)
    );
    echo json_encode($response);

} else {

    echo false;

}