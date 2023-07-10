<?php
//SetBank.php
if (!isset($_GET['Value']) or $_GET['Value'] == '' or $_GET['Value'] == 0) {
    JavaTools::JsTimeRefresh(0, './');
} else {


    require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
    $objGlobalVar = new GlobalVarTools();

    $Enabled = true;

    $objTimeTools = new TimeTools();
    $objAclTools = new ACLTools();

    //User info

    $UserId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserId'));

    $SCondition = "  IdKey = '$UserId' ";
    $objIWUser = $objORM->Fetch($SCondition, '*', TableIWUser);

    $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
    
    
    $ResNum = $UserId.date("YmdHis") . rand(11, 99);
    $ModifyStrTime = $objGlobalVar->JsonDecode($objTimeTools->getDateTimeNow())->date;
    $ModifyDateNow = $objGlobalVar->Nu2EN($objTimeTools->jdate("Y/m/d"));




    $UserId = @$objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserId'));

    if ($UserId == '') {

        JavaTools::JsTimeRefresh(0, './');

    } else {
        $BankName = $_GET['BankName'];
        $AddressId = $_GET['AddId'];
        $intValue = (int)$_GET['Value'];
        //$intValue = 1200;
        $AmountRial = $intValue * 10; // Price in rial

        if ($BankName == 'saman') {
            $objBankSaman = new SamanPayment($objGlobalVar->en2Base64($UserId,1));
            JavaTools::JsTimeRefresh(0,'https://sep.shaparak.ir/OnlinePG/SendToken?token='.$objBankSaman->getToken($AmountRial, $ResNum, $AddressId,  $objIWUser->CellNumber ));
            exit();

        }


    }

}




