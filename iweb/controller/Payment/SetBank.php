<?php
//SetBank.php
if (!isset($_GET['Value']) or $_GET['Value'] == '' or $_GET['Value'] == 0) {
    JavaTools::JsTimeRefresh(0, './');
} else {


    require IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
    $objGlobalVar = new GlobalVarTools();

    $Enabled = BoolEnum::BOOL_TRUE();

    $objTimeTools = new TimeTools();
    $objAclTools = new ACLTools();

    //User info

    $UserIdKey = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));

    $SCondition = "  IdKey = '$UserIdKey' ";
    $objIWUser = $objORM->Fetch($SCondition, '*', TableIWUser);

    $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
    $ModifyTime = $objTimeTools->jdate("H:i:s");
    $ModifyDate = $objTimeTools->jdate("Y/m/d");
    $ResNum = $UserIdKey.date("YmdHis") . rand(11, 99);
    $ModifyStrTime = $objGlobalVar->JsonDecode($objTimeTools->getDateTimeNow())->date;
    $ModifyDateNow = $objGlobalVar->Nu2EN($objTimeTools->jdate("Y/m/d"));




    $UserIdKey = @$objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));

    if ($UserIdKey == '') {

        JavaTools::JsTimeRefresh(0, './');

    } else {
        $BankName = $_GET['BankName'];
        $AddressId = $_GET['AddId'];
        $intValue = (int)$_GET['Value'];
        //$intValue = 1200;
        $AmountRial = $intValue * 10; // Price in rial

        if ($BankName == 'saman') {
            $objBankSaman = new SamanPayment($objGlobalVar->en2Base64($UserIdKey,1));
            JavaTools::JsTimeRefresh(0,'https://sep.shaparak.ir/OnlinePG/SendToken?token='.$objBankSaman->getToken($AmountRial, $ResNum, $AddressId,  $objIWUser->CellNumber ));
            exit();

        }


    }

}




