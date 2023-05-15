<?php
include dirname(__FILE__, 4) . "/iassets/include/DBLoader.php";

$gender = strtolower($_POST['gender']);
$category = $_POST['category'];
$GroupIdKey = @$objORM->Fetch( " Enabled = 1 and Name = '$category' ", "IdKey" , TableIWNewMenu2)->IdKey;
echo @$objORM->FetchJson(TableIWNewMenu3, " Enabled = 1 and GroupIdKey = '$GroupIdKey' ", 'Name,LocalName');