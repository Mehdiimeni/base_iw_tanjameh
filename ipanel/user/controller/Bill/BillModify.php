<?php
//BillModify.php
include_once IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include_once IW_ASSETS_FROM_PANEL . "include/UserInfo.php";

$apiMainName = 'Bill';
$blConfirm = 0;

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

        $BillId = $objAclTools->strReplace($objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->BillId), "_");
        $PayId = $objAclTools->strReplace($objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->PayId), "_");
        $blConfirm = 1;

        $BillType = substr($BillId, -2, 1);
        $strBillType = 'نامشخص';

        $intPay =  substr($PayId, 0, -5)*1000;



        switch ($BillType) {
            case "1":
                $strBillType = "آب";
                break;
            case "2":
                $strBillType = "برق";
                break;
            case "3":
                $strBillType = "گاز";
                break;
            case "4":
                $strBillType = "تلفن ثابت";
                break;
            case "5":
                $strBillType = "همراه";
                break;
            case "6":
                $strBillType = "عوارض شهرداری";
                break;
            case "7":
                $strBillType = "مالیات";
                break;
            case "8":
                $strBillType = "جرایم رانندگی";
                break;

        }


    }


}

if (isset($_POST['SubmitA']) and @$objGlobalVar->RefFormGet()[0] == null) {


    $objAclTools = new ACLTools();

    if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $BillId = $objAclTools->strReplace($objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->BillId), "_");
        $PayId = $objAclTools->strReplace($objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->PayId), "_");
        $blConfirm = 0;


        $arrPost = array('Customer_Id' => (int)$stdProfile->ApiId, 'BillId' => $BillId, 'PayId' => $PayId);
        $JsonPostData = $objAclTools->JsonEncode($arrPost);

        if($objKMN->Post($JsonPostData) != '') {
            JavaTools::JsAlertWithRefresh(FA_LC["pay_successful"], 0, '');
        }else {
            JavaTools::JsAlertWithRefresh(FA_LC["pay_unsuccessful"], 0, '');
        }
        $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
        JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
        exit();


    }


}









