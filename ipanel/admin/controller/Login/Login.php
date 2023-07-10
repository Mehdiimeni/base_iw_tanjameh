<?php
if (isset($_POST['SubmitL'])) {
    $objAclTools = new ACLTools();

    if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $UsernameL = $objAclTools->en2Base64($_POST['UsernameL'], 1);
        $PasswordL = $objAclTools->mdShal($_POST['PasswordL'], 0);
        $Enabled = true;
        $SCondition = "Username = '$UsernameL' and Password = '$PasswordL' and Enabled = $Enabled ";


        require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";

        if (!$objORM->DataExist($SCondition, TableIWAdmin)) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_info_error'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $Online = true;

            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            $now_modify = date("Y-m-d H:i:s");
            $iw_admin_id = $objORM->Fetch($SCondition, 'id', TableIWAdmin)->id;

            // observer
            $InSet =
                "Online = '$Online',
                 modify_ip = '$modify_ip',
                 modify_id = '$iw_admin_id',
                 last_modify = '$now_modify',
                 iw_admin_id  = '$iw_admin_id'";
            $objORM->DataAdd($InSet, TableIWAdminObserver);

            if (!$objORM->DataExist("iw_admin_id = $iw_admin_id ", TableIWAdminStatus,'iw_admin_id')) {
                $objORM->DataUpdate(
                    "iw_admin_id = $iw_admin_id",
                    "all_count_enter = all_count_enter + 1 ",
                    TableIWAdminStatus
                );
            } else {
                $objORM->DataAdd(
                    "iw_admin_id = $iw_admin_id ,
                    all_count_enter = 1 ",
                    TableIWAdminStatus
                );
            }

            $FOpen = fopen(IW_REPOSITORY_FROM_PANEL . 'log/login/admin/' . $iw_admin_id . '.iw', 'a+');
            fwrite($FOpen, "$iw_admin_id ==::==$now_modify==::==in\n");
            fclose($FOpen);

            $objGlobalVar = new GlobalVarTools();
            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            $objGlobalVar->setSessionVar('_IWAdminId', $iw_admin_id);
            $objGlobalVar->setCookieVar('_IWAdminId', $objAclTools->en2Base64($iw_admin_id, 1));

            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage));
            exit();

        }


    }

}