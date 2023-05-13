<?php

include dirname(__FILE__, 4) . "/iassets/include/DBLoader.php";

echo @$objORM->FetchJson(TableIWWebSiteAlert," Enabled = '1' ", '*','id');