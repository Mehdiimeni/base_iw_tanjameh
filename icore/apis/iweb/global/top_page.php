<?php
ini_set('allow_url_include', 'on');
include $_POST['protecol'].$_POST['url'] . "/iassets/include/DBLoader.php";
echo @$objORM->FetchJson(TableIWWebSiteInfo, " Enabled = 1 ", '*','id');