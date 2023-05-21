<?php

include $_POST['url'] . "/iassets/include/DBLoader.php";
echo @$objORM->FetchJson(TableIWWebSiteInfo, " Enabled = '1' ", '*','id');