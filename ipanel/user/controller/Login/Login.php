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
        $Enabled = BoolEnum::BOOL_TRUE();
        $SCondition = "Username = '$UsernameL' and Password = '$PasswordL' and Enabled = '$Enabled' ";

        require IW_ASSETS_FROM_PANEL . "include/DBLoader.php";


        if (!$objORM->DataExist($SCondition, TableIWUser)) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_info_error'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $Online = BoolEnum::BOOL_TRUE();
            $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            $ModifyTime = $objTimeTools->jdate("H:i:s");
            $ModifyDate = $objTimeTools->jdate("Y/m/d");

            $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;
            $objUserInfo = $objORM->Fetch($SCondition, 'IdKey,ApiId,GroupIdKey,GroupIdKey,Name,CellNumber,NationalCode', TableIWUser);
            $GroupIdKey = $objUserInfo->GroupIdKey;

            $objUserInfo->NationalCode == '' ? $NationalCode = '0000000000' : $NationalCode = $objUserInfo->NationalCode;

            $SCondition2 = "IdKey = '$GroupIdKey'";
            $UserGroupApiId = $objORM->Fetch($SCondition2, 'ApiId', TableIWUserGroup)->ApiId;

            $ModifyId = $objUserInfo->IdKey;
            $InSet = "";
            $InSet .= " Online = '$Online' ,";
            $InSet .= " ModifyIP = '$ModifyIP' ,";
            $InSet .= " ModifyTime = '$ModifyTime' ,";
            $InSet .= " ModifyDate = '$ModifyDate' ,";
            $InSet .= " ModifyStrTime = '$ModifyStrTime' ,";
            $InSet .= " ModifyId = '$ModifyId' ";

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
            $objGlobalVar->setSessionVar('_IWUserIdKey', $ModifyId);
            $objGlobalVar->setCookieVar('_IWUserIdKey', $objAclTools->en2Base64($ModifyId, 1));
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

        $Enabled = BoolEnum::BOOL_TRUE();
        $SCondition = "  Name = '$Name' OR Username = '$UsernameL' OR Email = '$Email' OR CellNumber = '$CellNumber'  ";

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
            $InSet .= " GroupIdKey = '12427ad5' ,";
            $InSet .= " Image = 'No Image' ,";
            $InSet .= " Description = '' ,";
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
        $Enabled = BoolEnum::BOOL_TRUE();
        $SCondition = "Email = '$Email'  and Enabled = '$Enabled' ";

        require IW_ASSETS_FROM_PANEL . "include/DBLoader.php";


        if (!$objORM->DataExist($SCondition, TableIWUser)) {
            JavaTools::JsAlertWithRefresh(FA_LC['email_forget_not_find'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $Online = BoolEnum::BOOL_TRUE();
            $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            $ModifyTime = $objTimeTools->jdate("H:i:s");
            $ModifyDate = $objTimeTools->jdate("Y/m/d");

            $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;
            $objUserInfo = $objORM->Fetch($SCondition, 'IdKey,Email,Name', TableIWUser);
            $ModifyId = $objUserInfo->IdKey;

            $Password = $objAclTools->mdShal($ModifyId, 0);

            $UCondition = " IdKey = '$ModifyId' ";
            $USet = "";
            $USet .= " Password = '$Password' ,";
            $USet .= " ModifyIP = '$ModifyIP' ,";
            $USet .= " ModifyTime = '$ModifyTime' ,";
            $USet .= " ModifyDate = '$ModifyDate' ,";
            $USet .= " ModifyStrTime = '$ModifyStrTime' ,";
            $USet .= " ModifyId = '$ModifyId' ";

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