<?php
require_once "../global/CommonInclude.php";

if (!empty($_POST['page_name_system'])) {
    $website_page_name = strtolower($_POST['page_name_system']);
    $condition = " Enabled = 1 and name = '$website_page_name' ";

    if ($objORM->DataExist($condition, TableIWWebSitePages,'id')) {
        $iw_website_pages_id = @$objORM->Fetch($condition, "id", TableIWWebSitePages)->id;

        if (!empty($_POST['adver_number'])) {
            $adver_number = strtolower($_POST['adver_number']);
            $condition = " Enabled = 1 and name = 'AdverSp$adver_number' and iw_website_pages_id = '$iw_website_pages_id' ";
            if ($objORM->DataExist($condition, TableIWWebSitePagesPart,'id')) {
                $iw_website_pages_part_id = @$objORM->Fetch($condition, "id", TableIWWebSitePagesPart)->id;
                $condition = " Enabled = 1 and iw_website_pages_part_id = '$iw_website_pages_part_id'  ";
                if ($objORM->DataExist($condition, TableIWWebSiteSpAdver,'id')) {
                    echo @$objORM->FetchJson(TableIWWebSiteSpAdver, $condition, '*', 'id', 1);
                } else {
                    echo false;
                }
            } else {
                echo false;
            }
        } else {
            echo false;
        }
    } else {
        echo false;
    }

} else {
    echo false;
}