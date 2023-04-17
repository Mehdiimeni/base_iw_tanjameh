<?php
//First3.php
require IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
require_once IW_ASSETS_FROM_PANEL . "include/UserInfo.php";

$apiMainName = 'customer/'.(int)$stdProfile->ApiId;
$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objKMN = new KMNConnection($objFileToolsInit->KeyValueFileReader()['MainApi'] . $apiMainName, $objFileToolsInit->KeyValueFileReader()['ApiAuto']);
$strNewUser = 0;
$strPanTrunc = $objGlobalVar->JsonDecodeArray($objKMN->Get())['PanTrunc'];

$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL.'img/');
$UserProfileImage = $objShowFile->ShowImage( '', $objShowFile->FileLocation( "userprofile" ), $stdProfile->Image, $stdProfile->Name, 85, 'style ="max-width: 100px; max-height: 100px"' );


if ($objGlobalVar->JsonDecodeArray($objKMN->Get())['PanTrunc'] == null)
    $strNewUser = 1;

// api stat
$apiMainName = 'stats/'.(int)$stdProfile->ApiId;

$objKMN = new KMNConnection($objFileToolsInit->KeyValueFileReader()['GenericApi'] . $apiMainName, $objFileToolsInit->KeyValueFileReader()['ApiAuto']);

$arrState = $objGlobalVar->JsonDecodeArray($objKMN->connect());

// bank refer page
if (@$_GET['backset'] == 't') {

   
    require IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
    require_once IW_ASSETS_FROM_PANEL . "include/IconTools.php";

    $objAclTools = new ACLTools();


        $PIN = 'o3bS4IIGtY7bvwFLv4O0';
        $wsdl_url = "https://pec.shaparak.ir/NewIPGServices/Confirm/ConfirmService.asmx?WSDL";

        $Token = $_REQUEST ["Token"];
        $status = $_REQUEST ["status"];
        $OrderId = $_REQUEST ["OrderId"];
        $TerminalNo = $_REQUEST ["TerminalNo"];
        $Amount = $objAclTools->strReplace($_REQUEST ["Amount"],",");
        $RRN = $_REQUEST ["RRN"];
        if ($RRN > 0 && $status == 0) {

            $params = array(
                "LoginAccount" => $PIN,
                "Token" => $Token
            );

            $client = new SoapClient ($wsdl_url);

            try {
                $result = $client->ConfirmPayment(array(
                    "requestData" => $params
                ));
                if ($result->ConfirmPaymentResult->Status != '0') {
                    $err_msg = "(<strong> کد خطا : " . $result->ConfirmPaymentResult->Status . "</strong>) " .
                        $result->ConfirmPaymentResult->Message;
                }
            } catch (Exception $ex) {
                $err_msg = $ex->getMessage();
            }
        } elseif ($status) {
            $err_msg = "کد خطای ارسال شده از طرف بانک $status " . "";
        } else {

            $err_msg = "پاسخی از سمت بانک ارسال نشد ";
        }
   /*
    $Token = $_REQUEST ["Token"];
    $status = $_REQUEST ["status"];
    $OrderId = rand(1000000, 100000000);
    $TerminalNo = $_REQUEST ["TerminalNumber"];
    $Amount = $_REQUEST ["Amount"];
    $RRN = $_REQUEST ["RRN"];
    $RefNum = $_REQUEST ["RefNum"];


    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://cut.pec.ir/ApiServices/Api/IPG/ConfirmTxn',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
  "TerminalNumber": 44332170,
  "Username": "rayatest",
  "Password": "123456",
  "Amount": ' . $Amount . ',
  "RefNum": "' . $RefNum . '",
  "Token": "' . $Token . '"
  
}',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic cC5hbWlyYW5pOjEyMzQ=',
            'Content-Type: application/ijson',
            'Cookie: cookiesession1=4DC8B385QQOHTZKB4EJHU4F2W3PC9D62'
        ),
    ));

    $response = curl_exec($curl);


    curl_close($curl);
    var_dump($response);
    exit();
*/
    $apiMainName = 'Transaction';
    $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
    $objKMN = new KMNConnection($objFileToolsInit->KeyValueFileReader()['MainApi'] . $apiMainName, $objFileToolsInit->KeyValueFileReader()['ApiAuto']);

    $arrPost = array('Customer_Id' => (int)$stdProfile->ApiId, 'Amount' => (int)$Amount, 'Token' => (string)$Token, 'Status' => 0, 'OrderId' => (int)$OrderId, 'TerminalNumber' => (int)$TerminalNo, 'RRN' => (int)$RRN);
    $JsonPostData = $objAclTools->JsonEncode($arrPost);

    $objKMN->Post($JsonPostData);

    $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
    JavaTools::JsTimeRefresh(0, '?ln=&part=Report&page=Transaction');
    exit();
}






