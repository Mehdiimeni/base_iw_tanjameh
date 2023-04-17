<?php 



include dirname(__FILE__,4) . "/iassets/include/DBLoader.php";


    $rows = array();
while($r = mysqli_fetch_assoc(@$objORM->Fetch(" Enabled = '1' ", '*', TableIWWebSiteInfo))) {
    $rows[] = $r;
}


    	
	$json_response = json_encode($rows);
	echo $json_response;