<?php
require_once "../global/CommonInclude.php";

if ($objORM->DataExist(" Enabled = 1 ", TableIWNewMenu)) {
    echo @$objORM->FetchJson(TableIWNewMenu, " Enabled = 1 ", '*');
} else {
    echo false;
}