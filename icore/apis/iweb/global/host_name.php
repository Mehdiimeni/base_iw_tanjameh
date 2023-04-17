<?php 

require dirname(__FILE__, 5) ."/vendor/autoload.php";
SessionTools::init();

$objGlobalVar = new GlobalVarTools();
$objACL = new ACLTools();

if (str_contains($objGlobalVar->JsonDecode($objGlobalVar->ServerVarToJson())->HTTP_HOST , 'localhost')){
    $response['error_reporting'] = 1;
}else{
    
    $response['error_reporting'] = 0;

}

$response['host'] =     $objGlobalVar->JsonDecode($objGlobalVar->ServerVarToJson())->HTTP_HOST;
	
	$json_response = json_encode($response);
	echo $json_response;