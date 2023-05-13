<?php

include dirname(__FILE__, 4) . "/iassets/include/DBLoader.php";

echo @$objORM->FetchJson(TableIWWebSiteInfo, " Enabled = '1' ", '*','id');