<?php

$apiMainName = 'Customer';
if (isset($_POST['SubmitL'])) {
    $objAclTools = new ACLTools();

    if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $UsernameL = $objAclTools->en2Base64($objAclTools->JsonDecode($objAclTools->PostVarToJson())->UsernameL, 1);
        $PasswordL = $objAclTools->mdShal($objAclTools->JsonDecode($objAclTools->PostVarToJson())->PasswordL, 0);
        $Enabled = true;
        $SCondition = "Username = '$UsernameL' and Password = '$PasswordL' and Enabled = $Enabled ";

        require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";


        if (!$objORM->DataExist($SCondition, TableIWUser)) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_info_error'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $Online = true;
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            
            

            $now_modify = date("Y-m-d H:i:s");
            $objUserInfo = $objORM->Fetch($SCondition, 'IdKey,ApiId,GroupIdKey,GroupIdKey,Name,CellNumber,NationalCode', TableIWUser);
            $GroupIdKey = $objUserInfo->GroupIdKey;

            $objUserInfo->NationalCode == '' ? $NationalCode = '0000000000' : $NationalCode = $objUserInfo->NationalCode;

            $SCondition2 = "IdKey = '$GroupIdKey'";
            $UserGroupApiId = $objORM->Fetch($SCondition2, 'ApiId', TableIWUserGroup)->ApiId;

            $ModifyId = $objUserInfo->IdKey;
            $InSet = "";
            $InSet .= " Online = '$Online' ,";
            $InSet .= " modify_ip = '$modify_ip' ,";
            
            
            $InSet .= " last_modify = '$now_modify' ,";
            $InSet .= " modify_id = $ModifyId ";

            $objORM->DataAdd($InSet, TableIWUserObserver);

            if ($objUserInfo->ApiId == '' and $UserGroupApiId != '') {

                $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
                $objKMN = new KMNConnection($objFileToolsInit->KeyValueFileReader()['MainApi'] . $apiMainName, $objFileToolsInit->KeyValueFileReader()['ApiAuto']);
                $arrPost = array('FirstName' => $objUserInfo->Name, 'LastName' => "", 'Level' => "Normal", 'Agency_Id' => (int)$UserGroupApiId, 'NationalCode' => $NationalCode, 'CellNumber' => $objUserInfo->CellNumber);
                $JsonPostData = $objAclTools->JsonEncode($arrPost);
                $arrApiId = $objAclTools->JsonDecodeArray($objKMN->Post($JsonPostData));
                $UserApiId = $arrApiId['Id'];
            }
            @$UserApiId != null ? $USet = "CountEnter = CountEnter + '1' , ApiId = '$UserApiId'" : $USet = "CountEnter = CountEnter + '1' ";
            $objORM->DataUpdate($SCondition, $USet, TableIWUser);

            $FOpen = fopen(IW_REPOSITORY_FROM_PANEL . 'log/login/user/' . $ModifyId . '.iw', 'a+');
            fwrite($FOpen, "$ModifyId==::==$ModifyStrTime==::==in\n");
            fclose($FOpen);

            $objGlobalVar = new GlobalVarTools();
            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            $objGlobalVar->setSessionVar('_IWUserId', $ModifyId);
            $objGlobalVar->setCookieVar('_IWUserId', $objAclTools->en2Base64($ModifyId, 1));
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage));
            exit();

        }


    }

}

if (isset($_POST['RegisterL'])) {
    $objAclTools = new ACLTools();

    if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $Name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Name);
        $Email = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Email);
        $CellNumber = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->CellNumber);
        $UsernameL = $objAclTools->en2Base64($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Username, 1);
        $PasswordL = $objAclTools->mdShal($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Password, 0);

        $Enabled = true;
        $SCondition = "  Name = '$Name' OR Username = '$UsernameL' OR Email = '$Email' OR CellNumber = '$CellNumber'  ";

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
            $InSet .= " GroupIdKey = '12427ad5' ,";
            $InSet .= " Image = 'No Image' ,";
            $InSet .= " Description = '' ,";
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
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage));
            exit();

        }


    }

}
if (isset($_POST['SubmitForget'])) {
    $objAclTools = new ACLTools();

    if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {
        $Email = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Email);
        $Enabled = true;
        $SCondition = "Email = '$Email'  and Enabled = $Enabled ";

        require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";


        if (!$objORM->DataExist($SCondition, TableIWUser)) {
            JavaTools::JsAlertWithRefresh(FA_LC['email_forget_not_find'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $Online = true;
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            
            

            $now_modify = date("Y-m-d H:i:s");
            $objUserInfo = $objORM->Fetch($SCondition, 'IdKey,Email,Name', TableIWUser);
            $ModifyId = $objUserInfo->IdKey;

            $Password = $objAclTools->mdShal($ModifyId, 0);

            $UCondition = " IdKey = '$ModifyId' ";
            $USet = "";
            $USet .= " Password = '$Password' ,";
            $USet .= " modify_ip = '$modify_ip' ,";
            
            
            $USet .= " last_modify = '$now_modify' ,";
            $USet .= " modify_id = $ModifyId ";

            $objORM->DataUpdate($UCondition, $USet, TableIWUser);


            $ok = (new \Tx\Mailer())
                ->setServer('mail.tanjameh.com', 25)
                ->setAuth('info@tanjameh.com', '1qaz!QAZ')
                ->setFrom('پرتال تن جامه', 'info@tanjameh.com')
                ->addTo($objUserInfo->Name, $objUserInfo->Email)
                ->setSubject(FA_LC["forget_password"])
                ->setBody(FA_LC["email_reset_body"] . '<br/>' . $ModifyId)
                ->send();

            JavaTools::JsAlertWithRefresh(FA_LC['email_forget_data_send'], 0, '');
            exit();

        }


    }

}