<?php
//Login.php

(new MakeDirectory)->MKDir(IW_REPOSITORY_FROM_PANEL . 'log/login/', 'user', 0755);

$objGlobalVar = new GlobalVarTools();
$UserId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserId'));
$objAclTools = new ACLTools();


if (@$objAclTools->NormalUserLogin(IW_REPOSITORY_FROM_PANEL . 'log/login/user/' . $UserId)) {

    (new FileCaller)->FileIncluderWithControler(IW_WEB_FROM_PANEL, 'User', 'Login');

} else {
    (new FileCaller)->FileIncluderWithControler(IW_WEB_FROM_PANEL, 'User', 'Account');
    exit();
}


if (isset($_POST['SubmitL'])) {


    $arrExcept = array('Email' => '', 'Mobile' => '');

    if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $UserNameL = $objAclTools->JsonDecode($objAclTools->PostVarToJson())->UserNameL;
        $PasswordL = $objAclTools->mdShal($objAclTools->JsonDecode($objAclTools->PostVarToJson())->PasswordL, 0);
        if ($UserNameL == '0000000000') {
            JavaTools::JsAlertWithRefresh(FA_LC['login_info_error'], 0, '');
            exit();
        }

        $Enabled = true;
        $SCondition = "(Email = '$UserNameL' or CellNumber = '$UserNameL'  or NationalCode = '$UserNameL'  ) and Password = '$PasswordL' and Enabled = $Enabled ";

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
            $UserGroup = $objORM->Fetch($SCondition2, 'IdKey,Name,Description', TableIWUserGroup);

            $ModifyId = $objUserInfo->IdKey;
            $InSet = "";
            $InSet .= " Online = '$Online' ,";
            $InSet .= " modify_ip = '$modify_ip' ,";
            
            
            $InSet .= " last_modify = '$now_modify' ,";
            $InSet .= " modify_id = $ModifyId ";

            $objORM->DataAdd($InSet, TableIWUserObserver);


            $USet = "CountEnter = CountEnter + '1' ";
            $objORM->DataUpdate($SCondition, $USet, TableIWUser);

            $FOpen = fopen(IW_REPOSITORY_FROM_PANEL . 'log/login/user/' . $ModifyId . '.iw', 'a+');
            fwrite($FOpen, "$ModifyId==::==$ModifyStrTime==::==in\n");
            fclose($FOpen);

            $objGlobalVar->setSessionVar('_IWUserId', $ModifyId);
            $objGlobalVar->setCookieVar('_IWUserId', $objAclTools->en2Base64($ModifyId, 1));


            $UserSessionId = session_id();
            $SCondition = "  ( UserId = '$ModifyId' or UserSessionId = '$UserSessionId'  ) and ProductId != ''  ";
            $intCountAddToCart = $objORM->DataCount($SCondition, TableIWUserTempCart);


            if ($intCountAddToCart > 0) {

                JavaTools::JsTimeRefresh(0, './?part=User&page=Shop');

            } else {
                $objGlobalVar = new GlobalVarTools();
                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage));
            }
            exit();

        }


    }

}
