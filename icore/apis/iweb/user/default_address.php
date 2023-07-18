<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../../iassets/include/DBLoader.php";


if (
    !empty($_POST['user_id'])
) {

    $iw_user_id = $objACLTools->CleanStr($_POST['user_id']);

    echo @$objORM->FetchJson(
        TableIWUserAddressDetails . ' as d inner join ' . TableIWUserAddress . ' as a on d.id = a.iw_user_address_details_id',
        " a.is_default = 1 and d.Enabled = 1 and a.iw_user_id = $iw_user_id ",
        '*',
        'id',
        1
    );


} else {
    echo false;
}