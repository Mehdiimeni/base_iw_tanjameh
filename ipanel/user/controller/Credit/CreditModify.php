<?php
//CreditModify3.php

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

//IPG
$strIPG = '';

foreach (array_values((array)IPGEnum::IPGName())[0] as $Key => $Value) {
    $Key == 'pecl' ? $strSelected = 'selected' : $strSelected = '';
    $strIPG .= '<option ' . $strSelected . ' value="' . $Key . '">' . $Value . '</option>';
}

if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();

    if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {
        $strHost = (new IPTools(IW_DEFINE_FROM_PANEL))->getHostAddressLoad();
        $Amount = (int)$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Amount) * 10000;
        $IPG = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->IPG);
        $IPG('https://'.$strHost . '/ipanel/user.php?ln=&backset=' . $IPG . '&Amount=' . $Amount, $Amount);

    }


}

function pec($strRedirect, $Amount)
{
    try {
        $objParsianIPG = new Dpsoft\Parsian\Parsian('X4m6yOaH0em36yII45L6');
        $response = $objParsianIPG->request($Amount, $strRedirect, rand(1, 140000));
        JavaTools::JsTimeRefresh(0, $objParsianIPG->redirect());
        exit();
    } catch (\Throwable $exception) {

        var_dump($exception->getMessage());
        die();
    }

}

function pecl($strRedirect, $Amount)
{
    $apiMainName = 'Transaction';

    include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
    $Enabled = BoolEnum::BOOL_TRUE();
    $objAclTools = new ACLTools();

    $UserIdKey = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));

    $SCondition = "IdKey = '$UserIdKey' and  Enabled = '$Enabled' ";
    $stdProfile = $objORM->Fetch($SCondition, 'GroupApiId,GroupIdKey', TableIWUser);

    $apiMainName = 'Agency?$filter=Id%20eq%20' . $stdProfile->GroupApiId;
    $Enabled = BoolEnum::BOOL_TRUE();

    $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
    $objKMN = new KMNConnection($objFileToolsInit->KeyValueFileReader()['MainApi'] . $apiMainName, $objFileToolsInit->KeyValueFileReader()['ApiAuto']);
    $arrGroupData = $objGlobalVar->ObjectJsonToSelectArray($objKMN->GetWithFilter(), 1);

    if ($arrGroupData[0]->TerminalNumber == null) {
        $GroupIdKey = $stdProfile->GroupIdKey;
        $SCondition = "IdKey = '$GroupIdKey' and  Enabled = '$Enabled' ";
        $arrGroupData[] = $objORM->Fetch($SCondition, 'TerminalNumber,Username,Password', TableIWUserGroup);
    }
    try {
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
          "TerminalNumber": ' . (int)$arrGroupData[0]->TerminalNumber . ',
          "Username": "' . (string)$arrGroupData[0]->Username . '",
          "Password": "' . (string)$arrGroupData[0]->Password . '",
          "Amount": ' . (int)$Amount . ',
          "ReservationNumber": "' . rand(1, 140000) . '",
          "CallBackUrl": "' . $strRedirect . '",
          "AdditionalData": "",
          "CellNo": "09394161057"}',

            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic cC5hbWlyYW5pOjEyMzQ=',
                'Content-Type: application/json',
                'Cookie: cookiesession1=068DEF6AMEOLBCRPXIZGYFC9N7PNB702'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
    } catch (\Exception $ex) {
        var_dump($response);
        var_dump($ex->getMessage());
        die();
    }

// user profile
    $Enabled = BoolEnum::BOOL_TRUE();
    $UserIdKey = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));
    $SCondition = "IdKey = '$UserIdKey' and  Enabled = '$Enabled' ";
    $stdProfile = $objORM->Fetch($SCondition, 'ApiId', TableIWUser);

    if ($objAclTools->JsonDecodeArray($response)['success'])
        JavaTools::JsTimeRefresh(0, 'https://cut.pec.ir/Payment?Token=' . $objAclTools->JsonDecodeArray($response)['data']['Token'] . '&gid=' . $stdProfile->ApiId);
    exit();

}


function pep($strRedirect, $Amount)
{
    /*
        $UserIdKey = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));
    
        $SCondition = "IdKey = '$UserIdKey' and  Enabled = '$Enabled' ";
        $stdProfile = $objORM->Fetch($SCondition, 'GroupApiId,GroupIdKey', TableIWUser);
    
        $apiMainName = 'Agency?$filter=Id%20eq%20' . $stdProfile->GroupApiId;
        $Enabled = BoolEnum::BOOL_TRUE();
    
        $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
        $objKMN = new KMNConnection($objFileToolsInit->KeyValueFileReader()['MainApi'] . $apiMainName, $objFileToolsInit->KeyValueFileReader()['ApiAuto']);
        $arrGroupData = $objGlobalVar->ObjectJsonToSelectArray($objKMN->GetWithFilter(), 1);
    
        if ($arrGroupData[0]->TerminalNumber == null) {
            $GroupIdKey = $stdProfile->GroupIdKey;
            $SCondition = "IdKey = '$GroupIdKey' and  Enabled = '$Enabled' ";
            $arrGroupData[] = $objORM->Fetch($SCondition, 'TerminalNumber,Username,Password', TableIWUserGroup);
        }
    
    */
    try {

        $objPasargadIPG = new \Pasargad\Pasargad(5064387, 2316655, $strRedirect, IW_DEFINE_FROM_PANEL . "conf/pepipg.txt");
        // send to pasargad ipg
        $objPasargadIPG->setAmount($Amount);
        $objPasargadIPG->setInvoiceNumber(rand(1, 140000));
        $objPasargadIPG->setInvoiceDate(date("Y/m/d H:i:s"));

        JavaTools::JsTimeRefresh(0, $objPasargadIPG->redirect());
        exit();
    } catch (\Exception $ex) {
        var_dump($ex->getMessage());
        die();
    }
}







