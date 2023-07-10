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

        $Enabled = true;
        $SCondition = "   Username = '$UsernameL' OR Email = '$Email' OR CellNumber = '$CellNumber'  ";

        require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";

        if ($objORM->DataExist($SCondition, TableIWUser)) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            
            

            

            $now_modify = date("Y-m-d H:i:s");
            $ModifyId = $IdKey;

            $InSet = "";
            
            $InSet .= " Enabled = $Enabled ,";
            $InSet .= " Name = '$Name' ,";
            $InSet .= " Email = '$Email' ,";
            $InSet .= " CellNumber = '$CellNumber' ,";
            $InSet .= " GroupIdKey = '634a167f' ,";
            $InSet .= " Image = 'No Image' ,";
            $InSet .= " Description = '$UsernameSelect' ,";
            $InSet .= " UserName = '$UsernameL' ,";
            $InSet .= " Password = '$PasswordL' ,";
            $InSet .= " modify_ip = '$modify_ip' ,";
            
            
            $InSet .= " last_modify = '$now_modify' ,";
            $InSet .= " modify_id = $ModifyId ";

            $objORM->DataAdd($InSet, TableIWUser);

            $Online = true;
            $InSet = "";
            $InSet .= " Online = '$Online' ,";
            $InSet .= " modify_ip = '$modify_ip' ,";
            
            
            $InSet .= " last_modify = '$now_modify' ,";
            $InSet .= " modify_id = $ModifyId ";

            $objORM->DataAdd($InSet, TableIWUserObserver);

            $USet = "CountEnter = CountEnter + '1'    ";
            $objORM->DataUpdate($SCondition, $USet, TableIWUser);

            $FOpen = fopen(IW_REPOSITORY_FROM_PANEL . 'log/login/user/' . $ModifyId . '.iw', 'a+');
            fwrite($FOpen, "$ModifyId==::==$ModifyStrTime==::==in\n");
            fclose($FOpen);

            $objGlobalVar = new GlobalVarTools();
            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            $objGlobalVar->setSessionVar('_IWUserId', $ModifyId);
            $objGlobalVar->setCookieVar('_IWUserId', $objAclTools->en2Base64($ModifyId, 1));
            JavaTools::JsAlertWithRefresh(FA_LC['welcome_first_time_login'], 0, '?part=User&page=Account');
            exit();

        }


    }

}