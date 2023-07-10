<?php
//Profile.php
require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
$objGlobalVar = new GlobalVarTools();
$Enabled = true;

$UserId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserId'));
$SCondition = "  IdKey = '$UserId' ";
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

        $Enabled = true;
        $SCondition = "      NationalCode = '$NationalCode' and IdKey != '$UserId'  ";

        require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";

        if ($objORM->DataExist($SCondition, TableIWUser)) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            
            


            $now_modify = date("Y-m-d H:i:s");

            $UCondition = " IdKey = '$UserId'";

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
            $USet .= " modify_ip = '$modify_ip' ,";
            
            
            $USet .= " last_modify = '$now_modify' ,";
            $USet .= " ModifyId = '$UserId' ";

            $objORM->DataUpdate($UCondition, $USet, TableIWUser);


            $objGlobalVar = new GlobalVarTools();
            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;

            JavaTools::JsAlertWithRefresh(FA_LC['update_success'], 0, '');
            exit();

        }


    }

}
