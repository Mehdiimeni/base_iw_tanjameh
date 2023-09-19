<?php
require_once "./CommonInclude.php";

if ($objORM->DataExist(" Enabled = 1 ", TableIWWebSiteAlert, 'id')) {
    echo @$objORM->FetchJson(TableIWWebSiteAlert, " Enabled = '1' ", '*', 'id');
} else {
    echo false;
}