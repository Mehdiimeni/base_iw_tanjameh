<?php
//UserGroupModify.php

$apiMainName = 'Agency';

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
$Enabled = true;

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
        $Enabled = true;
        $SCondition = "  Name = '$Name'  ";

        if ($objORM->DataExist($SCondition, TableIWUserGroup)) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            
            

            

            $now_modify = date("Y-m-d H:i:s");
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

            $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
            $objKMN = new KMNConnection($objFileToolsInit->KeyValueFileReader()['MainApi'] . $apiMainName, $objFileToolsInit->KeyValueFileReader()['ApiAuto']);
            $arrPost = array('Name' => $Name,'TerminalNumber'=>$TerminalNumber,'Username'=>$Username,'Password'=>$Password);
            $JsonPostData = $objAclTools->JsonEncode($arrPost);

            $arrApiId = $objAclTools->JsonDecodeArray($objKMN->Post($JsonPostData));
            $ApiId = $arrApiId['Id'];
            $AppSecret = $arrApiId['AppSecret'];
            $AppKey = $arrApiId['AppKey'];

            $InSet = "";
            
            $InSet .= " Enabled = $Enabled ,";
            $InSet .= " Name = '$Name' ,";
            $InSet .= " SuperUser = '$SuperUser' ,";
            $InSet .= " SuperTrade = '$SuperTrade' ,";
            $InSet .= " Description = '$Description' ,";
            $InSet .= " modify_ip = '$modify_ip' ,";
            
            
            $InSet .= " last_modify = '$now_modify' ,";
            $InSet .= " modify_id = $ModifyId, ";
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
    $SCondition = "  id = $IdKey ";
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

            $SCondition = "Name = '$Name' and id!= $IdKey  ";

            if ($objORM->DataExist($SCondition, TableIWUserGroup)) {
                JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
                exit();

            } else {

                $objTimeTools = new TimeTools();
                $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
                
                
                $now_modify = date("Y-m-d H:i:s");
                $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

                $UCondition = " id = $IdKey ";
                $USet = "";
                $USet .= " Name = '$Name' ,";
                $USet .= " SuperUser = '$SuperUser' ,";
                $USet .= " SuperTrade = '$SuperTrade' ,";
                $USet .= " Description = '$Description' ,";
                $USet .= " modify_ip = '$modify_ip' ,";
                
                
                $USet .= " last_modify = '$now_modify' ,";
                $USet .= " modify_id = $ModifyId ";

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

        $Enabled = true;

        $objTimeTools = new TimeTools();
        $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
        
        

        

        $now_modify = date("Y-m-d H:i:s");
        $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));


        $InSet = "";
        
        $InSet .= " Enabled = $Enabled ,";
        $InSet .= " Name = '$Name' ,";
        $InSet .= " Email = '$Email' ,";
        $InSet .= " Image = 'no image' ,";
        $InSet .= " CellNumber = '$CellNumber' ,";
        $InSet .= " CountEnter = '$CountEnter' ,";
        $InSet .= " UserName = '$UsernameL' ,";
        $InSet .= " Password = '$PasswordL' ,";
        $InSet .= " GroupIdKey = '$GroupIdKey' ,";
        $InSet .= " Description = '$Description' ,";
        $InSet .= " modify_ip = '$modify_ip' ,";
        
        
        $InSet .= " last_modify = '$now_modify' ,";
        $InSet .= " modify_id = $ModifyId, ";
        $InSet .= " GroupApiId = '$GroupApiId', ";
        $InSet .= " NationalCode = '$NationalCode' ";

        $objORM->DataAdd($InSet, TableIWUser);

        /*$strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
        JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
        exit();*/

    }
}
