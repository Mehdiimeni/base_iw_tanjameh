<?php
//PinModify.php
include_once IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include_once IW_ASSETS_FROM_PANEL . "include/UserInfo.php";

$apiMainName = 'PinCharge';

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

//Operator
$strOperator = '';

foreach (array_values((array)PinEnum::CellOperator())[0] as $Key => $Value) {
    $strOperator .= '<option value="' . $Key . '">' . $Value . '</option>';
}

//Type
$strType = '';
foreach (array_values((array)PinEnum::PinType())[0] as $Key => $Value) {
    $strType .= '<option value="' . $Key . '">' . $Value . '</option>';
}


$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objKMN = new KMNConnection($objFileToolsInit->KeyValueFileReader()['MainApi'] . $apiMainName, $objFileToolsInit->KeyValueFileReader()['ApiAuto']);

if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();

    if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $Operator = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Operator);
        $Type = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Type);


        $arrPost = array('Customer_Id' => (int)$stdProfile->ApiId, 'Operator' => $Operator, 'Type' => $Type);
        $JsonPostData = $objAclTools->JsonEncode($arrPost);

        $objKMN->Post($JsonPostData);

        $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
        JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
        exit();


    }

}








