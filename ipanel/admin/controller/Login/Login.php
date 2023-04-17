<?php
if (isset($_POST['SubmitL'])) {
    $objAclTools = new ACLTools();

    if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $UsernameL = $objAclTools->en2Base64($objAclTools->JsonDecode($objAclTools->PostVarToJson())->UsernameL, 1);
        $PasswordL = $objAclTools->mdShal($objAclTools->JsonDecode($objAclTools->PostVarToJson())->PasswordL, 0);
        $Enabled = BoolEnum::BOOL_TRUE();
        $SCondition = "Username = '$UsernameL' and Password = '$PasswordL' and Enabled = '$Enabled' ";

        require IW_ASSETS_FROM_PANEL."include/DBLoader.php";

        if (!$objORM->DataExist($SCondition, TableIWAdmin)) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_info_error'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $Online = BoolEnum::BOOL_TRUE();
            $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            $ModifyTime = $objTimeTools->jdate("H:i:s");
            $ModifyDate = $objTimeTools->jdate("Y/m/d");

            $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;
            $ModifyId = $objORM->Fetch($SCondition, 'IdKey', TableIWAdmin)->IdKey;
            $InSet = "";
            $InSet .= " Online = '$Online' ,";
            $InSet .= " ModifyIP = '$ModifyIP' ,";
            $InSet .= " ModifyTime = '$ModifyTime' ,";
            $InSet .= " ModifyDate = '$ModifyDate' ,";
            $InSet .= " ModifyStrTime = '$ModifyStrTime' ,";
            $InSet .= " ModifyId = '$ModifyId' ";

            $objORM->DataAdd($InSet, TableIWAdminObserver);

            $USet = "CountEnter = CountEnter + '1'    ";
            $objORM->DataUpdate($SCondition, $USet, TableIWAdmin);

            $FOpen = fopen(IW_REPOSITORY_FROM_PANEL . 'log/login/admin/' . $ModifyId . '.iw', 'a+');
            fwrite($FOpen, "$ModifyId==::==$ModifyStrTime==::==in\n");
            fclose($FOpen);

            $objGlobalVar = new GlobalVarTools();
            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            $objGlobalVar->setSessionVar('_IWAdminIdKey', $ModifyId);
            $objGlobalVar->setCookieVar('_IWAdminIdKey', $objAclTools->en2Base64($ModifyId, 1));
             JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage));
            exit();

        }


    }

}