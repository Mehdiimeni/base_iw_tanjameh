<?php
include dirname(__FILE__, 4) . "/iassets/include/DBLoader.php";

$gender = strtolower($_POST['gender']);
$gender != '' ? $condition = " Enabled = 1 and Name = '$gender' " : $condition = " Enabled = 1  " ;
$GroupIdKey = @$objORM->Fetch( " Enabled = 1 and Name = '$gender' ", "IdKey" , TableIWNewMenu)->IdKey;
echo @$objORM->FetchJson(TableIWNewMenu2, " Enabled = 1 and GroupIdKey = '$GroupIdKey' ", 'Name,LocalName');