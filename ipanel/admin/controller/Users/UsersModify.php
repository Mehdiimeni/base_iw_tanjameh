<?php


//UsersModify.php
$apiMainName = 'Customer';

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
//table name
$strTableNames = '';
foreach ((new ACLTools())->TableNames() as $TableNameList) {
    $strTableNames .= '<option>' . $TableNameList . '</option>';
}

//Group Name
$strGroupIdKey = '';
$SCondition = " Enabled = $Enabled and ApiId !='' ORDER BY id ";
foreach ($objORM->FetchAll($SCondition, 'Name,id,ApiId', TableIWUserGroup) as $ListItem) {
    $strGroupIdKey .= '<option value="' . $ListItem->id . '::==::' . $ListItem->ApiId . '">' . $ListItem->Name . '</option>';
}

if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();

    $arrExcept = array('NationalCode'=>'','CellNumber'=>'','Card'=>'','Description'=>'');

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

        if($FileNewName == null)
            $FileNewName == 'NO IMAGE';


        $Name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Name);
        $Email = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Email);
        $NationalCode = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->NationalCode);
        $CellNumber = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->CellNumber);
        $GroupIdKeyWithGuid = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->GroupIdKey);
        $PanHash = $objAclTools->enBase64($objAclTools->strReplace($objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Card),"-"),0);

        $arrGroupIdKeyWithGuid = explode("::==::", $GroupIdKeyWithGuid);
        $GroupIdKey = $arrGroupIdKeyWithGuid[0];
        $GroupApiId = (int)$arrGroupIdKeyWithGuid[1];
        $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);

        $UsernameL = $objAclTools->en2Base64($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Username, 1);
        $PasswordL = $objAclTools->mdShal($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Password, 0);

        $Enabled = true;
        $SCondition = " ( Name = '$Name' OR Username = '$UsernameL' OR Email = '$Email' ) and GroupIdKey = '$GroupIdKey' ";

        if ($objORM->DataExist($SCondition, TableIWUser)) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            
            

            

            $now_modify = date("Y-m-d H:i:s");
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

            $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
            $objKMN = new KMNConnection($objFileToolsInit->KeyValueFileReader()['MainApi'] . $apiMainName, $objFileToolsInit->KeyValueFileReader()['ApiAuto']);
            $arrPost = array('FirstName' => $Name, 'LastName' => "", 'Level' => "Normal", 'Agency_Id' => $GroupApiId, 'NationalCode' => $NationalCode, 'CellNumber' => $CellNumber,'PanHash'=>$PanHash);
            $JsonPostData = $objAclTools->JsonEncode($arrPost);

            $arrApiId = $objAclTools->JsonDecodeArray($objKMN->Post($JsonPostData));

            $ApiId = $arrApiId['Id'];
            $InSet = "";
            
            $InSet .= " Enabled = $Enabled ,";
            $InSet .= " Name = '$Name' ,";
            $InSet .= " Email = '$Email' ,";
            $InSet .= " Image = '$FileNewName' ,";
            $InSet .= " CellNumber = '$CellNumber' ,";
            $InSet .= " UserName = '$UsernameL' ,";
            $InSet .= " Password = '$PasswordL' ,";
            $InSet .= " GroupIdKey = '$GroupIdKey' ,";
            $InSet .= " Description = '$Description' ,";
            $InSet .= " modify_ip = '$modify_ip' ,";
            
            
            $InSet .= " last_modify = '$now_modify' ,";
            $InSet .= " modify_id = $ModifyId, ";
            $InSet .= " ApiId = '$ApiId', ";
            $InSet .= " GroupApiId = '$GroupApiId', ";
            $InSet .= " NationalCode = '$NationalCode' ";

            $objORM->DataAdd($InSet, TableIWUser);
            if ($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->name != null) {
                $objStorageTools->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');
                $objStorageTools->ImageOptAndStorage($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->tmp_name, 'userprofile', $FileNewName);
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
    $SCondition = "  id = $IdKey ";
    $objEditView = $objORM->Fetch($SCondition, 'GroupIdKey,Name,NationalCode,CellNumber,Email,Username,Description', TableIWUser);
    $trueUsername = $objAclTools->de2Base64($objEditView->Username);


    //Group Name
    $SCondition = "  IdKey = '$objEditView->GroupIdKey' ";
    $Item = $objORM->Fetch($SCondition, 'Name,id,ApiId', TableIWUserGroup);
    $strGroupIdKey = '<option selected value="' .$Item->id . '::==::' . $Item->ApiId . '">' . $Item->Name . '</option>';
    $SCondition = " Enabled = $Enabled and ApiId !='' ORDER BY id ";
    foreach ($objORM->FetchAll($SCondition, 'Name,id,ApiId', TableIWUserGroup) as $ListItem) {
        $strGroupIdKey .= '<option value="' . $ListItem->id . '::==::' . $ListItem->ApiId . '">' . $ListItem->Name . '</option>';
    }

    if (isset($_POST['SubmitM'])) {
        $objAclTools = new ACLTools();

        $arrExcept = array('NationalCode'=>'','CellNumber'=>'','Card'=>'','Description'=>'');

    if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(),$arrExcept))
    {
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
            $PanHash = $objAclTools->enBase64($objAclTools->strReplace($objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Card),"-"),0);


            $arrGroupIdKeyWithGuid = explode("::==::", $GroupIdKeyWithGuid);
            $GroupIdKey = $arrGroupIdKeyWithGuid[0];
            $GroupApiId = (int)$arrGroupIdKeyWithGuid[1];


            $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);

            $UsernameL = $objAclTools->en2Base64($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Username, 1);
            $PasswordL = $objAclTools->mdShal($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Password, 0);

            $SCondition = "( Name = '$Name' OR Username = '$UsernameL' OR Email = '$Email' ) and GroupIdKey = '$GroupIdKey' and id!= $IdKey  ";

            if ($objORM->DataExist($SCondition, TableIWUser)) {
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
                $USet .= " Email = '$Email' ,";
                $USet .= " CellNumber = '$CellNumber' ,";
                $USet .= " UserName = '$UsernameL' ,";
                $USet .= " Password = '$PasswordL' ,";
                $USet .= " GroupIdKey = '$GroupIdKey' ,";
                $USet .= " Description = '$Description' ,";
                $USet .= " modify_ip = '$modify_ip' ,";
                
                
                $USet .= " last_modify = '$now_modify' ,";
                $USet .= " modify_id = $ModifyId, ";
                $USet .= " GroupApiId = '$GroupApiId', ";
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


if (@$_GET['a'] == 'add') {

    $objAclTools = new ACLTools();
    for ($i = 0; $i = 17239; $i++) {
        $Description = 'کاربر';
        $CountEnter = rand(100, 999);
        $NationalCode = rand(10000000, 9999999999);
        $CellNumber = rand(100000000, 999999999);
        $CellNumber = '09' . $CellNumber;
        $arrGroupId = array('12d7cffd', '1cb1f415', '2a8a757d', '52dfc6f4', '543718fa', '5af060c9', '760e8f1f', '76392883', '8c97393b', '8c9edd09', '8dafe78d', '9c520f2b', 'a6a0ae6b', 'b2049617', 'c66ecd19', 'cbdc9985',
            'd5ae4f98', 'e28d1f05', 'f922cad6', 'ff441795');

        $arrlistesm = file(IW_MAIN_ROOT_FROM_PANEL . "esm.txt");
        $arrlistfamil = file(IW_MAIN_ROOT_FROM_PANEL . "famil.txt");
        $Name = $arrlistesm[rand(0, 751)] . ' ' . $arrlistfamil[rand(0, 174)];

        $Email = 'info@raya24.ir';

        $randId = array_rand($arrGroupId);
        $GroupIdKey = $arrGroupId[$randId];
        $GroupApiId = rand(13, 32);

        $UsernameL = $objAclTools->en2Base64($Name, 1);
        $PasswordL = $objAclTools->mdShal($Name, 0);

        $Enabled = true;


        $objTimeTools = new TimeTools();
        $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
        
        

        

        $now_modify = date("Y-m-d H:i:s");
        $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserId'));


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
    }

}

