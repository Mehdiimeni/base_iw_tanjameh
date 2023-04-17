<?php
//Address.php
require IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
$objGlobalVar = new GlobalVarTools();
$Enabled = BoolEnum::BOOL_TRUE();
$UserIdKey = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));

//Country
$strCountryIdKey = '';
$SCondition = " Enabled = '$Enabled' ORDER BY IdRow ";
foreach ($objORM->FetchAll($SCondition, 'Name,IdKey', TableIWACountry) as $ListItem) {
    $strCountryIdKey .= '<option value="' . $ListItem->IdKey . '">' . $ListItem->Name . '</option>';
}

//Addresses
$strAdresses = '';
$SCondition = " Enabled = '$Enabled' and UserIdKey = '$UserIdKey' ORDER BY IdRow ";
foreach ($objORM->FetchAll($SCondition, 'NicName,Address', TableIWUserAddress) as $ListItem) {

    $strAdresses .= '<br/>';
    $strAdresses .= '<h5><b>' . $ListItem->NicName . '</b></h5>';
    $strAdresses .= '<p>' . $ListItem->Address . '</p>';
    $strAdresses .= '<br/><hr><br/>';
}

if (isset($_POST['SubmitL'])) {
    $objAclTools = new ACLTools();

    $arrExcept = array('Description' => '', 'OtherTel' => '');
    if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $CountryIdKey = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->CountryIdKey);
        $NicName = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->NicName);
        $PostCode = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->PostCode);
        $OtherTel = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->OtherTel);
        $Address = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Address);
        $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);


        $Enabled = BoolEnum::BOOL_TRUE();
        $SCondition = "   (NicName = '$NicName' OR PostCode = '$PostCode' OR Address = '$Address' ) and UserIdKey = '$UserIdKey' ";

        require IW_ASSETS_FROM_PANEL . "include/DBLoader.php";

        if ($objORM->DataExist($SCondition, TableIWUserAddress)) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            $ModifyTime = $objTimeTools->jdate("H:i:s");
            $ModifyDate = $objTimeTools->jdate("Y/m/d");

            $IdKey = $objAclTools->IdKey();

            $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;

            $InSet = "";
            $InSet .= " IdKey = '$IdKey' ,";
            $InSet .= " Enabled = '$Enabled' ,";
            $InSet .= " CountryIdKey = '$CountryIdKey' ,";
            $InSet .= " UserIdKey = '$UserIdKey' ,";
            $InSet .= " NicName = '$NicName' ,";
            $InSet .= " PostCode = '$PostCode' ,";
            $InSet .= " OtherTel = '$OtherTel' ,";
            $InSet .= " Address = '$Address' ,";
            $InSet .= " Description = '$Description' ,";
            $InSet .= " ModifyIP = '$ModifyIP' ,";
            $InSet .= " ModifyTime = '$ModifyTime' ,";
            $InSet .= " ModifyDate = '$ModifyDate' ,";
            $InSet .= " ModifyStrTime = '$ModifyStrTime' ,";
            $InSet .= " ModifyId = '$UserIdKey' ";

            $objORM->DataAdd($InSet, TableIWUserAddress);


            $SCondition = "  UserIdKey = '$UserIdKey'  and ProductId != ''  ";
            $intCountAddToCart = $objORM->DataCount($SCondition, TableIWUserTempCart);


            if ($intCountAddToCart > 0) {

                JavaTools::JsTimeRefresh(0, './?part=User&page=Checkout');

            } else {
                $objGlobalVar = new GlobalVarTools();
                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsAlertWithRefresh(FA_LC['insert_success'], 0, './?part=User&page=Address');
            }
            exit();

        }


    }

}