<?php
//Address.php
require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
$objGlobalVar = new GlobalVarTools();
$Enabled = true;
$UserId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserId'));

//Country
$strCountryIdKey = '';
$SCondition = " Enabled = $Enabled ORDER BY id ";
foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWACountry) as $ListItem) {
    $strCountryIdKey .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
}

//Addresses
$strAdresses = '';
$SCondition = " Enabled = $Enabled and UserId = '$UserId' ORDER BY id ";
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


        $Enabled = true;
        $SCondition = "   (NicName = '$NicName' OR PostCode = '$PostCode' OR Address = '$Address' ) and UserId = '$UserId' ";

        require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";

        if ($objORM->DataExist($SCondition, TableIWUserAddress)) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            
            

            

            $now_modify = date("Y-m-d H:i:s");

            $InSet = "";
            
            $InSet .= " Enabled = $Enabled ,";
            $InSet .= " CountryIdKey = '$CountryIdKey' ,";
            $InSet .= " UserId = '$UserId' ,";
            $InSet .= " NicName = '$NicName' ,";
            $InSet .= " PostCode = '$PostCode' ,";
            $InSet .= " OtherTel = '$OtherTel' ,";
            $InSet .= " Address = '$Address' ,";
            $InSet .= " Description = '$Description' ,";
            $InSet .= " modify_ip = '$modify_ip' ,";
            
            
            $InSet .= " last_modify = '$now_modify' ,";
            $InSet .= " ModifyId = '$UserId' ";

            $objORM->DataAdd($InSet, TableIWUserAddress);


            $SCondition = "  UserId = '$UserId'  and ProductId != ''  ";
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