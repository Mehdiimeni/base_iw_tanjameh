<?php
//Forgot.php

if (isset($_POST['SubmitForget'])) {
    $objAclTools = new ACLTools();

    $arrExcept = array('Email' => '', 'Mobile' => '');

    if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $UserNameL = $objAclTools->JsonDecode($objAclTools->PostVarToJson())->UserNameL;
        $PasswordL = $objAclTools->mdShal($objAclTools->JsonDecode($objAclTools->PostVarToJson())->PasswordL, 0);
        if($UserNameL == '0000000000'){
            JavaTools::JsAlertWithRefresh(FA_LC['login_info_error'], 0, '');
            exit();
        }

        $Enabled = BoolEnum::BOOL_TRUE();
        $SCondition = "(Email = '$UserNameL' or CellNumber = '$UserNameL'  or NationalCode = '$UserNameL'  )  and Enabled = '$Enabled' ";

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
            $objUserInfo = $objORM->Fetch($SCondition, 'IdKey,Email,Name,CellNumber', TableIWUser);
            $ModifyId = $objUserInfo->IdKey;
            $randomPass = rand(111111, 999999);

            /*
                        $ok = (new \Tx\Mailer())
                            ->setServer('mail.tanjameh.com', 25)
                            ->setAuth('info@tanjameh.com', '1qaz!QAZ')
                            ->setFrom('پرتال تن جامه', 'info@tanjameh.com')
                            ->addTo($objUserInfo->Name, $objUserInfo->Email)
                            ->setSubject(FA_LC["forget_password"])
                            ->setBody(FA_LC["email_reset_body"].'<br/>'.$ModifyId)
                            ->send();
            */

            // SMS

            $objSms = new SmsConnections('3000505');
            $objSms->ForgetSms($objUserInfo->CellNumber, $objUserInfo->Name, $randomPass);

            // count sms
            $strExpireDate = date("m-Y");
            $UCondition = " CompanyIdKey = 'e45fef12' and ExpireDate = '$strExpireDate' ";
            $USet = " Count = Count + 1 ";
            $objORM->DataUpdate($UCondition, $USet, TableIWSMSAllConnect);


            $Password = $objAclTools->mdShal($randomPass, 0);

            $UCondition = " IdKey = '$ModifyId' ";
            $USet = "";
            $USet .= " Password = '$Password' ,";
            $USet .= " ChangePass = '1' ,";
            $USet .= " ModifyIP = '$ModifyIP' ,";
            $USet .= " ModifyTime = '$ModifyTime' ,";
            $USet .= " ModifyDate = '$ModifyDate' ,";
            $USet .= " ModifyStrTime = '$ModifyStrTime' ,";
            $USet .= " ModifyId = '$ModifyId' ";

            $objORM->DataUpdate($UCondition, $USet, TableIWUser);
            JavaTools::JsAlertWithRefresh(FA_LC['forget_data_send'], 0, '?part=User&page=Login');
            exit();

        }


    }

}
