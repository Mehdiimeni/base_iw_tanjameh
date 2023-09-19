<?php
require_once "./CommonInclude.php";

if ($objORM->DataExist(" Enabled = 1 ", TableIWWebSiteInfo, 'id')) {
    echo @$objORM->FetchJson(TableIWWebSiteInfo, " Enabled = 1 ", '*', 'id');
} else {
    echo false;
}