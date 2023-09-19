<?php
require_once "./CommonInclude.php";

if ($objORM->DataExist(" Enabled = 1 ", TableIWACountry, 'id')) {
    echo @$objORM->FetchJson(TableIWACountry, " Enabled = 1 ", '*', 'id');
} else {
    echo false;
}