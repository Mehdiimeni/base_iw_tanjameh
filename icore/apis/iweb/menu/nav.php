<?php
include dirname(__FILE__, 4) . "/iassets/include/DBLoader.php";
echo @$objORM->FetchJson(TableIWNewMenu, " Enabled = 1 ", '*');