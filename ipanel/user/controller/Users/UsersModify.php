<?php
//UsersModify.php
$apiMainName = 'Customer';

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include IW_ASSETS_FROM_PANEL . "include/UserInfo.php";
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
//table name
$strTableNames = '';
foreach ((new ACLTools())->TableNames() as $TableNameList) {
    $strTableNames .= '<option>' . $TableNameList . '</option>';
}

//Group Name
$strGroupIdKey = '';
$ModifyId = @$objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));
$SCondition = " Enabled = '$Enabled' and ModifyId = '$ModifyId' ORDER BY IdRow ";
foreach ($objORM->FetchAll($SCondition, 'Name,IdKey,ApiId', TableIWUserGroup) as $ListItem) {
    $strGroupIdKey .= '<option value="' . $ListItem->IdKey . '::==::'.$ListItem->ApiId.'">' . $ListItem->Name . '</option>';
}

if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();
    $arrExcept = array('GroupIdKey'=>'','Image'=>'','Description'=>'');
    if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(),$arrExcept)) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        if ($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->name != null) {
            $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
            $objStorageTools = new StorageTools($objFileToolsInit->KeyValueFileReader()['MainName']);

            $FileExt = $objStorageTools->FindFileExt('', $objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->tmp_name);
            if (!$objStorageTools->FileAllowFormat(FileSizeEnum::ExtImage(), $FileExt)) {

                JavaTools::JsAlertWithRefresh(FA_LC['enter_format_file_error'], 0, '');
                exit();
            }
            if (!$objStorageTools->FileAllowSize('userprofile', $objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->tmp_name)) {

                JavaTools::JsAlertWithRefresh(FA_LC['enter_size_file_error'], 0, '');
                exit();
            }

            $FileNewName = $objStorageTools->FileSetNewName($FileExt);

        }


        $Name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Name);
        $Email = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Email);
        $NationalCode = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->NationalCode);
        $CellNumber = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->CellNumber);
        $GroupIdKeyWithGuid = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->GroupIdKey);

        $arrGroupIdKeyWithGuid = explode("::==::",$GroupIdKeyWithGuid);
        $GroupIdKey = $arrGroupIdKeyWithGuid[0];
        $GroupApiId = (int)$stdProfile->GroupApiId;

        $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);
        $UsernameL = $objAclTools->en2Base64($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Username, 1);
        $PasswordL = $objAclTools->mdShal($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Password, 0);

        $Enabled = BoolEnum::BOOL_TRUE();
        $SCondition = " ( Name = '$Name' OR Username = '$UsernameL'  ) and GroupIdKey = '$GroupIdKey' ";

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
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));

            // Guid fro api odata
            $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
            $objKMN = new KMNConnection($objFileToolsInit->KeyValueFileReader()['MainApi'] . $apiMainName, $objFileToolsInit->KeyValueFileReader()['ApiAuto']);
            $arrPost = array('FirstName' => $Name, 'LastName' => "", 'Level' => "Normal", 'Agency_Id' => $GroupApiId, 'NationalCode'=>$NationalCode, 'CellNumber'=>$CellNumber);
            $JsonPostData = $objAclTools->JsonEncode($arrPost);

            $arrApiId = $objAclTools->JsonDecodeArray($objKMN->Post($JsonPostData));

            $ApiId = $arrApiId['Id'];

            $InSet = "";
            $InSet .= " IdKey = '$IdKey' ,";
            $InSet .= " Enabled = '$Enabled' ,";
            $InSet .= " Name = '$Name' ,";
            $InSet .= " Email = '$Email' ,";
            $InSet .= " Image = '$FileNewName' ,";
            $InSet .= " CellNumber = '$CellNumber' ,";
            $InSet .= " UserName = '$UsernameL' ,";
            $InSet .= " Password = '$PasswordL' ,";
            $InSet .= " GroupIdKey = '$GroupIdKey' ,";
            $InSet .= " Description = '$Description' ,";
            $InSet .= " ModifyIP = '$ModifyIP' ,";
            $InSet .= " ModifyTime = '$ModifyTime' ,";
            $InSet .= " ModifyDate = '$ModifyDate' ,";
            $InSet .= " ModifyStrTime = '$ModifyStrTime' ,";
            $InSet .= " ModifyId = '$ModifyId', ";
            $InSet .= " ApiId = '$ApiId', ";
            $InSet .= " GroupApiId = '$GroupApiId', ";
            $InSet .= " NationalCode = '$NationalCode' ";


            $objORM->DataAdd($InSet, TableIWUser);
            if ($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->name != null) {
                $objStorageTools->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');
                $objStorageTools->ImageOptAndStorage($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->tmp_name, 'Userprofile', $FileNewName);
            }

            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (@$objGlobalVar->RefFormGet()[0] != null) {
    $objAclTools = new ACLTools();
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  IdKey = '$IdKey' ";
    $objEditView = $objORM->Fetch($SCondition, '*', TableIWUser);
    $trueUsername = $objAclTools->de2Base64($objEditView->Username);

    //Group Name
    $SCondition = "  IdKey = '$objEditView->GroupIdKey' ";
    $Item = $objORM->Fetch($SCondition, 'Name,IdKey,SuperUser', TableIWUserGroup);
    $strGroupIdKey = '<option selected value="' . $Item->IdKey . '">' . $Item->Name . '</option>';
    if (@$strGroupIdKey->SuperUser )
        $strSuper = 1;

    $SCondition = " Enabled = '$Enabled' ORDER BY IdRow ";
    foreach ($objORM->FetchAll($SCondition, 'Name,IdKey,ApiId', TableIWUserGroup) as $ListItem) {
        $strGroupIdKey .= '<option value="' . $ListItem->IdKey . '::==::'.$ListItem->ApiId.'">' . $ListItem->Name . '</option>';
    }

    if (isset($_POST['SubmitM'])) {


        $arrExcept = array('GroupIdKey'=>'','Image'=>'','Description'=>'');
        if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(),$arrExcept)) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {

            if ($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->name != null) {
                $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
                $objStorageTools = new StorageTools($objFileToolsInit->KeyValueFileReader()['MainName']);

                $FileExt = $objStorageTools->FindFileExt('', $objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->tmp_name);
                if (!$objStorageTools->FileAllowFormat(FileSizeEnum::ExtImage(), $FileExt)) {

                    JavaTools::JsAlertWithRefresh(FA_LC['enter_format_file_error'], 0, '');
                    exit();
                }
                if (!$objStorageTools->FileAllowSize('userprofile', $objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->tmp_name)) {

                    JavaTools::JsAlertWithRefresh(FA_LC['enter_size_file_error'], 0, '');
                    exit();
                }

                $FileNewName = $objStorageTools->FileSetNewName($FileExt);

            }

            $Name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Name);
            $Email = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Email);
            $NationalCode = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->NationalCode);
            $CellNumber = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->CellNumber);
            $GroupIdKeyWithGuid = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->GroupIdKey);

            $arrGroupIdKeyWithGuid = explode("::==::",$GroupIdKeyWithGuid);
            $GroupIdKey = $arrGroupIdKeyWithGuid[0];


            $GroupApiId = (int)$stdProfile->GroupApiId;


            $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);

            $UsernameL = $objAclTools->en2Base64($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Username, 1);
            $PasswordL = $objAclTools->mdShal($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Password, 0);

            $SCondition = "( Name = '$Name' OR Username = '$UsernameL' OR Email = '$Email' ) and GroupIdKey = '$GroupIdKey' and IdKey != '$IdKey'  ";

            if ($objORM->DataExist($SCondition, TableIWUser)) {
                JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
                exit();

            } else {

                $objTimeTools = new TimeTools();
                $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
                $ModifyTime = $objTimeTools->jdate("H:i:s");
                $ModifyDate = $objTimeTools->jdate("Y/m/d");
                $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;
                $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));

                $UCondition = " IdKey = '$IdKey' ";
                $USet = "";
                $USet .= " Name = '$Name' ,";
                $USet .= " Email = '$Email' ,";
                $USet .= " Image = '$FileNewName' ,";
                $USet .= " CellNumber = '$CellNumber' ,";
                $USet .= " UserName = '$UsernameL' ,";
                $USet .= " Password = '$PasswordL' ,";
                $USet .= " Description = '$Description' ,";
                $USet .= " ModifyIP = '$ModifyIP' ,";
                $USet .= " ModifyTime = '$ModifyTime' ,";
                $USet .= " ModifyDate = '$ModifyDate' ,";
                $USet .= " ModifyStrTime = '$ModifyStrTime' ,";
                $USet .= " ModifyId = '$ModifyId', ";
                $USet .= " NationalCode = '$NationalCode' ";

                if ($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->name != null) {

                    $USet .= " ,Image = '$FileNewName' ";
                    $objStorageTools->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');
                    $objStorageTools->ImageOptAndStorage($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->tmp_name, 'userprofile', $FileNewName);
                }

                $objORM->DataUpdate($UCondition, $USet, TableIWUser);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}




