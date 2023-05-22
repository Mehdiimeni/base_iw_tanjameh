<?php
ini_set('allow_url_include', 'on');
include  "../../iassets/include/DBLoader.php";
echo @$objORM->FetchJson(TableIWWebSiteInfo, " Enabled = 1 ", '*','id');