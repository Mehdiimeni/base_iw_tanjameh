<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../../iassets/include/DBLoader.php";

if ($objORM->DataExist(" Enabled = 1 ", TableIWWebSiteAlert, 'id')) {
    echo @$objORM->FetchJson(TableIWWebSiteAlert, " Enabled = '1' ", '*', 'id');
} else {
    echo false;
}