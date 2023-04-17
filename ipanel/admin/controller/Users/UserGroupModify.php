<?php
//UserGroupModify.php

$apiMainName = 'Agency';

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
$Enabled = BoolEnum::BOOL_TRUE();

switch ($objGlobalVar->JsonDecode($objGlobalVar->GetVarToJsonNoSet())->modify) {
    case 'add' :
        $strModifyTitle = FA_LC["add"];
        break;
    case 'edit' :
        $strModifyTitle = FA_LC["edit"];
        break;
    case 'view' :
        $strModifyTitle = FA_LC["view"];
        break;
}

if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();
    $arrExcept = array('TerminalNumber'=>'','Username'=>'','Password'=>'','Description'=>'');

    if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(),$arrExcept)) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $Name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Name);
        $TerminalNumber = (int)$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->TerminalNumber);
        $Username = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Username);
        $Password = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Password);
        $SuperUser = @$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->SuperUser);
        if ($SuperUser == null)
            $SuperUser = 0;

        $SuperTrade = @$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->SuperTrade);
        if ($SuperTrade == null)
            $SuperTrade = 0;
        $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);
        $Enabled = BoolEnum::BOOL_TRUE();
        $SCondition = "  Name = '$Name'  ";

        if ($objORM->DataExist($SCondition, TableIWUserGroup)) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            $ModifyTime = $objTimeTools->jdate("H:i:s");
            $ModifyDate = $objTimeTools->jdate("Y/m/d");

            $IdKey = $objAclTools->IdKey();

            $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminIdKey'));

            $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
            $objKMN = new KMNConnection($objFileToolsInit->KeyValueFileReader()['MainApi'] . $apiMainName, $objFileToolsInit->KeyValueFileReader()['ApiAuto']);
            $arrPost = array('Name' => $Name,'TerminalNumber'=>$TerminalNumber,'Username'=>$Username,'Password'=>$Password);
            $JsonPostData = $objAclTools->JsonEncode($arrPost);

            $arrApiId = $objAclTools->JsonDecodeArray($objKMN->Post($JsonPostData));
            $ApiId = $arrApiId['Id'];
            $AppSecret = $arrApiId['AppSecret'];
            $AppKey = $arrApiId['AppKey'];

            $InSet = "";
            $InSet .= " IdKey = '$IdKey' ,";
            $InSet .= " Enabled = '$Enabled' ,";
            $InSet .= " Name = '$Name' ,";
            $InSet .= " SuperUser = '$SuperUser' ,";
            $InSet .= " SuperTrade = '$SuperTrade' ,";
            $InSet .= " Description = '$Description' ,";
            $InSet .= " ModifyIP = '$ModifyIP' ,";
            $InSet .= " ModifyTime = '$ModifyTime' ,";
            $InSet .= " ModifyDate = '$ModifyDate' ,";
            $InSet .= " ModifyStrTime = '$ModifyStrTime' ,";
            $InSet .= " ModifyId = '$ModifyId', ";
            $InSet .= " ApiId = '$ApiId', ";
            $InSet .= " AppSecret = '$AppSecret', ";
            $InSet .= " TerminalNumber = '$TerminalNumber', ";
            $InSet .= " Username = '$Username', ";
            $InSet .= " Password = '$Password', ";
            $InSet .= " AppKey = '$AppKey' ";

            $objORM->DataAdd($InSet, TableIWUserGroup);

            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (@$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  IdKey = '$IdKey' ";
    $objEditView = $objORM->Fetch($SCondition, '*', TableIWUserGroup);

    if (isset($_POST['SubmitM'])) {
        $objAclTools = new ACLTools();
        $arrExcept = array('TerminalNumber'=>'','Username'=>'','Password'=>'','Description'=>'');

        if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(),$arrExcept)) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {

            $Name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Name);
            $SuperUser = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->SuperUser);
            if ($SuperUser == null)
                $SuperUser = 0;
            $SuperTrade = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->SuperTrade);
            if ($SuperTrade == null)
                $SuperTrade = 0;
            $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);

            $SCondition = "Name = '$Name' and IdKey != '$IdKey'  ";

            if ($objORM->DataExist($SCondition, TableIWUserGroup)) {
                JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
                exit();

            } else {

                $objTimeTools = new TimeTools();
                $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
                $ModifyTime = $objTimeTools->jdate("H:i:s");
                $ModifyDate = $objTimeTools->jdate("Y/m/d");
                $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;
                $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminIdKey'));

                $UCondition = " IdKey = '$IdKey' ";
                $USet = "";
                $USet .= " Name = '$Name' ,";
                $USet .= " SuperUser = '$SuperUser' ,";
                $USet .= " SuperTrade = '$SuperTrade' ,";
                $USet .= " Description = '$Description' ,";
                $USet .= " ModifyIP = '$ModifyIP' ,";
                $USet .= " ModifyTime = '$ModifyTime' ,";
                $USet .= " ModifyDate = '$ModifyDate' ,";
                $USet .= " ModifyStrTime = '$ModifyStrTime' ,";
                $USet .= " ModifyId = '$ModifyId' ";

                $objORM->DataUpdate($UCondition, $USet, TableIWUserGroup);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}

if (@$_GET['a'] == 'add') {

    $objAclTools = new ACLTools();
    $CountEnter = rand(10, 8974);

    $GroupIdKey = '1291bf29';
    $GroupApiId = '47';

    $csvFile = file(IW_MAIN_ROOT_FROM_PANEL . "caffenet.csv");

    $data = [];
    foreach ($csvFile as $line) {
        $data[] = str_getcsv($line);
    }
    $counter = 0;
    foreach ($data as $rowData) {
        if ($counter++ == 0 )
            continue;

        $Name = $objAclTools->CleanStr($rowData[2]);

        $Email = 'info@raya24.ir';
        $CellNumber = '0' . $objAclTools->CleanStr($rowData[4]);

        $UsernameL = $objAclTools->en2Base64($objAclTools->CleanStr($rowData[4]), 1);
        $PasswordL = $objAclTools->mdShal($objAclTools->CleanStr($rowData[4]), 0);
        $Description = $objAclTools->CleanStr($rowData[1]).' '.$objAclTools->CleanStr($rowData[5]).' '.$objAclTools->CleanStr($rowData[6]) ;
        $NationalCode = $objAclTools->CleanStr($rowData[3]);

        $Enabled = BoolEnum::BOOL_TRUE();

        $objTimeTools = new TimeTools();
        $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
        $ModifyTime = $objTimeTools->jdate("H:i:s");
        $ModifyDate = $objTimeTools->jdate("Y/m/d");

        $IdKey = $objAclTools->IdKey();

        $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;
        $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminIdKey'));


        $InSet = "";
        $InSet .= " IdKey = '$IdKey' ,";
        $InSet .= " Enabled = '$Enabled' ,";
        $InSet .= " Name = '$Name' ,";
        $InSet .= " Email = '$Email' ,";
        $InSet .= " Image = 'no image' ,";
        $InSet .= " CellNumber = '$CellNumber' ,";
        $InSet .= " CountEnter = '$CountEnter' ,";
        $InSet .= " UserName = '$UsernameL' ,";
        $InSet .= " Password = '$PasswordL' ,";
        $InSet .= " GroupIdKey = '$GroupIdKey' ,";
        $InSet .= " Description = '$Description' ,";
        $InSet .= " ModifyIP = '$ModifyIP' ,";
        $InSet .= " ModifyTime = '$ModifyTime' ,";
        $InSet .= " ModifyDate = '$ModifyDate' ,";
        $InSet .= " ModifyStrTime = '$ModifyStrTime' ,";
        $InSet .= " ModifyId = '$ModifyId', ";
        $InSet .= " GroupApiId = '$GroupApiId', ";
        $InSet .= " NationalCode = '$NationalCode' ";

        $objORM->DataAdd($InSet, TableIWUser);

        /*$strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
        JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
        exit();*/

    }
}
