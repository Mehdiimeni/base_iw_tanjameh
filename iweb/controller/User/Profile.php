<?php
//Profile.php
include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
$objGlobalVar = new GlobalVarTools();
$Enabled = BoolEnum::BOOL_TRUE();

$UserIdKey = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));
$SCondition = "  IdKey = '$UserIdKey' ";
$objEditView = $objORM->Fetch($SCondition, '*', TableIWUser);

$strUsernameSelect ='';
if ($objEditView->Description == 'email') {
    $strUsernameSelect .= '<option value="email"  selected >' . FA_LC["email"] . '</option>';
}else{
    $strUsernameSelect .= '<option value="email"   >' . FA_LC["email"] . '</option>';
}
if ($objEditView->Description == 'mobile'){
    $strUsernameSelect .= '<option value="mobile" selected>' . FA_LC["mobile"] . '</option>';
}else{
    $strUsernameSelect .= '<option value="mobile" >' . FA_LC["mobile"] . '</option>';
}


if (isset($_POST['RegisterE'])) {
    $objAclTools = new ACLTools();

    if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $Name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Name);
        $Email = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Email);
        $CellNumber = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->CellNumber);
        $NationalCode = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->NationalCode);
        $UsernameSelect = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->UsernameSelect);

        if ($UsernameSelect == 'mobile')
            $UsernameL = $objAclTools->en2Base64($CellNumber, 1);

        if ($UsernameSelect == 'email')
            $UsernameL = $objAclTools->en2Base64($Email, 1);
        $PasswordL = $objAclTools->mdShal($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Password, 0);

        $Enabled = BoolEnum::BOOL_TRUE();
        $SCondition = "      NationalCode = '$NationalCode' and IdKey != '$UserIdKey'  ";

        include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";

        if ($objORM->DataExist($SCondition, TableIWUser)) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            $ModifyTime = $objTimeTools->jdate("H:i:s");
            $ModifyDate = $objTimeTools->jdate("Y/m/d");


            $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;

            $UCondition = " IdKey = '$UserIdKey'";

            $USet = "";
            $USet .= " Name = '$Name' ,";
            $USet .= " Email = '$Email' ,";
            $USet .= " CellNumber = '$CellNumber' ,";
            $USet .= " NationalCode = '$NationalCode' ,";
            $USet .= " GroupIdKey = '634a167f' ,";
            $USet .= " Image = 'No Image' ,";
            $USet .= " Description = '$UsernameSelect' ,";
            $USet .= " UserName = '$UsernameL' ,";
            $USet .= " Password = '$PasswordL' ,";
            $USet .= " ModifyIP = '$ModifyIP' ,";
            $USet .= " ModifyTime = '$ModifyTime' ,";
            $USet .= " ModifyDate = '$ModifyDate' ,";
            $USet .= " ModifyStrTime = '$ModifyStrTime' ,";
            $USet .= " ModifyId = '$UserIdKey' ";

            $objORM->DataUpdate($UCondition, $USet, TableIWUser);


            $objGlobalVar = new GlobalVarTools();
            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;

            JavaTools::JsAlertWithRefresh(FA_LC['update_success'], 0, '');
            exit();

        }


    }

}
