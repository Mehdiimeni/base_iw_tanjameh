<?php
//CreditModify.php

$apiMainName = 'Transaction';

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
$Enabled = BoolEnum::BOOL_TRUE();

switch ($objGlobalVar->JsonDecode($objGlobalVar->GetVarToJsonNoSet())->modify) {
    case 'add' :
        $strModifyTitle = FA_LC["add"];
        break;
    case 'edit' :
        $strModifyTitle = FA_LC["edit"];
        break;
    case 'view' :
        $strModifyTitle = FA_LC["view"];
        break;
}

//Card Holders Name
$strAmount = '';

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objKMN = new KMNConnection($objFileToolsInit->KeyValueFileReader()['MainApi'] . $apiMainName, $objFileToolsInit->KeyValueFileReader()['ApiAuto']);

foreach (array(25000, 26000, 27000, 28000, 29000, 30000) as $ListItem) {
    $strAmount .= '<option value="' . $ListItem . '">' . $ListItem . '</option>';

}


if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();

    if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $Amount = (int)$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Amount) * 10000;
        /*
                $Token = (string)rand(1000000,2000000);
                $Status = 1;
                $OrderId = rand(1000000,2000000);
                $TerminalNo = 44825519;
                $RRN = rand(1000000000,2000000000);
                $objTimeTools = new TimeTools();
                $ModifyStrTime = "2021-11-16T00:00:00+03:30";

                $arrPost = array('Customer_Id' => 1, 'Amount'=>$Amount, 'Token' => $Token, 'Status' => $Status,'OrderId'=>$OrderId,'TerminalNumber'=>$TerminalNo,'RRN'=>$RRN);
                $JsonPostData = $objAclTools->JsonEncode($arrPost);

                $objKMN->Post($JsonPostData);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
                exit();
        */
        /* parsiyan
                ini_set ( "soap.wsdl_cache_enabled", "0" );


                $PIN = 'X4m6yOaH0em36yII45L6';
                $wsdl_url = "https://pec.shaparak.ir/NewIPGServices/Sale/SaleService.asmx?WSDL";
                $site_call_back_url = "https://payraga.ir/ipanel/user.php?ln=&backset=t";

                $amount = $Amount ;
                $order_id = rand(1,140000);

                $params = array (
                    "LoginAccount" => $PIN,
                    "Amount" => $amount,
                    "OrderId" => $order_id,
                    "CallBackUrl" => $site_call_back_url
                );

                $client = new SoapClient ( $wsdl_url );

                try {
                    $result = $client->SalePaymentRequest ( array (
                        "requestData" => $params
                    ) );

                    if ($result->SalePaymentRequestResult->Token && $result->SalePaymentRequestResult->Status === 0) {

                        JavaTools::JsTimeRefresh(0, "https://pec.shaparak.ir/NewIPG/?Token=" . $result->SalePaymentRequestResult->Token );
                        exit ();
                    }
                    elseif ( $result->SalePaymentRequestResult->Status  != '0') {
                        $err_msg = "(<strong> کد خطا : " . $result->SalePaymentRequestResult->Status . "</strong>) " .
                            $result->SalePaymentRequestResult->Message ;
                    }
                } catch ( Exception $ex ) {
                    $err_msg =  $ex->getMessage()  ;
                }
        */


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://cut.pec.ir/AcqApiServices/api/IPG/GetToken',
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
  "ReservationNumber": "' . rand(1, 140000) . '",
  "CallBackUrl": "https://tanjameh.com/ipanel/user.php?ln=&backset=t&Amount=' . $Amount . '",
  "AdditionalData": "",
  "CellNo": "09394161057"
}',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic cC5hbWlyYW5pOjEyMzQ=',
                'Content-Type: application/ijson',
                'Cookie: cookiesession1=4DC8B385QQOHTZKB4EJHU4F2W3PC9D62'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");

// user profile
        $Enabled = BoolEnum::BOOL_TRUE();
        $UserIdKey = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));
        $SCondition = "IdKey = '$UserIdKey' and  Enabled = '$Enabled' ";
        $stdProfile = $objORM->Fetch($SCondition, 'Name,Image,GroupIdKey,CountEnter,ApiId,GroupApiId', TableIWUser);

        if ($objAclTools->JsonDecodeArray($response)['success'])
            JavaTools::JsTimeRefresh(0, 'https://cut.pec.ir/Payment?Token=' . $objAclTools->JsonDecodeArray($response)['data']['Token'] . '&gid=' . $stdProfile->ApiId);
        exit();


    }


}







