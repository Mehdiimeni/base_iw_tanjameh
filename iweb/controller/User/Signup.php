<?php
//SignupShop.php
$strUsernameSelect = '';
$strUsernameSelect .= '<option value="email" selected>' . FA_LC["email"] . '</option>';
$strUsernameSelect .= '<option value="mobile">' . FA_LC["mobile"] . '</option>';

if (isset($_POST['RegisterL'])) {
    $objAclTools = new ACLTools();

    if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $Name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Name);
        $Email = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Email);
        $CellNumber = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->CellNumber);
        $UsernameSelect = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->UsernameSelect);

        if ($UsernameSelect == 'mobile')
            $UsernameL = $objAclTools->en2Base64($CellNumber, 1);

        if ($UsernameSelect == 'email')
            $UsernameL = $objAclTools->en2Base64($Email, 1);


        $PasswordL = $objAclTools->mdShal($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Password, 0);

        $Enabled = BoolEnum::BOOL_TRUE();
        $SCondition = "   Username = '$UsernameL' OR Email = '$Email' OR CellNumber = '$CellNumber'  ";

        require IW_ASSETS_FROM_PANEL . "include/DBLoader.php";

        if ($objORM->DataExist($SCondition, TableIWUser)) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            $ModifyTime = $objTimeTools->jdate("H:i:s");
            $ModifyDate = $objTimeTools->jdate("Y/m/d");

            $IdKey = $objAclTools->IdKey();

            $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;
            $ModifyId = $IdKey;

            $InSet = "";
            $InSet .= " IdKey = '$IdKey' ,";
            $InSet .= " Enabled = '$Enabled' ,";
            $InSet .= " Name = '$Name' ,";
            $InSet .= " Email = '$Email' ,";
            $InSet .= " CellNumber = '$CellNumber' ,";
            $InSet .= " GroupIdKey = '634a167f' ,";
            $InSet .= " Image = 'No Image' ,";
            $InSet .= " Description = '$UsernameSelect' ,";
            $InSet .= " UserName = '$UsernameL' ,";
            $InSet .= " Password = '$PasswordL' ,";
            $InSet .= " ModifyIP = '$ModifyIP' ,";
            $InSet .= " ModifyTime = '$ModifyTime' ,";
            $InSet .= " ModifyDate = '$ModifyDate' ,";
            $InSet .= " ModifyStrTime = '$ModifyStrTime' ,";
            $InSet .= " ModifyId = '$ModifyId' ";

            $objORM->DataAdd($InSet, TableIWUser);

            $Online = BoolEnum::BOOL_TRUE();
            $InSet = "";
            $InSet .= " Online = '$Online' ,";
            $InSet .= " ModifyIP = '$ModifyIP' ,";
            $InSet .= " ModifyTime = '$ModifyTime' ,";
            $InSet .= " ModifyDate = '$ModifyDate' ,";
            $InSet .= " ModifyStrTime = '$ModifyStrTime' ,";
            $InSet .= " ModifyId = '$ModifyId' ";

            $objORM->DataAdd($InSet, TableIWUserObserver);

            $USet = "CountEnter = CountEnter + '1'    ";
            $objORM->DataUpdate($SCondition, $USet, TableIWUser);

            $FOpen = fopen(IW_REPOSITORY_FROM_PANEL . 'log/login/user/' . $ModifyId . '.iw', 'a+');
            fwrite($FOpen, "$ModifyId==::==$ModifyStrTime==::==in\n");
            fclose($FOpen);

            $objGlobalVar = new GlobalVarTools();
            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            $objGlobalVar->setSessionVar('_IWUserIdKey', $ModifyId);
            $objGlobalVar->setCookieVar('_IWUserIdKey', $objAclTools->en2Base64($ModifyId, 1));
            JavaTools::JsAlertWithRefresh(FA_LC['welcome_first_time_login'], 0, '?part=User&page=Account');
            exit();

        }


    }

}