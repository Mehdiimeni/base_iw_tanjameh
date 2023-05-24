<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include dirname(__FILE__, 4) . "/iassets/include/DBLoader.php";


if (isset($_POST['page_name_system'])) {
    $website_page_name = strtolower($_POST['page_name_system']);
    $condition = " Enabled = 1 and name = '$website_page_name' ";

    $iw_web_pages_id = @$objORM->Fetch($condition, "id", TableIWWebSitePages)->id;

    if (isset($_POST['adver_number'])) {
        $adver_number = strtolower($_POST['adver_number']);
        $condition = "  iw_web_pages_id = '$iw_web_pages_id' and Enabled = 1 and name = 'Adver$adver_number'  ";
    }

    $iw_web_pages_part_id = @$objORM->Fetch($condition, "id", TableIWWebSitePagesPart)->id;
}
$condition_statement = @$objORM->Fetch("  iw_web_pages_part_id = '$iw_web_pages_part_id' and Enabled = 1   ", "condition_statement", TableIWWebSiteBannerAdver)->condition_statement;
echo @$objORM->FetchJsonWhitoutCondition(TableIWAPIProducts, $condition_statement, 'IdRow');