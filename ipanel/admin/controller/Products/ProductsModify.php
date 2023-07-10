<?php
//ProductsModify.php


//SubMenuModify.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
$Enabled = true;

$SCondition = " Enabled = $Enabled ORDER BY id ";


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


//Sub 2 Menu Name
$strMenuIdKey = '';
$SCondition = " Enabled = $Enabled ORDER BY id ";
foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWWebSub2Menu) as $ListItem) {
    $strMenuIdKey .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
}

if (isset($_POST['SubmitApi']) and @$objGlobalVar->RefFormGet()[0] == null) {


    // API Count and Connect
    $objAsos = new AsosConnections();


    $ApiCategoryName = 'ProductsList';
    $ApiReplacePeriod = 2;
    $ApiGetLive = 0;

    $objReqular = new Regularization();
    $objAclTools = new ACLTools();
    $objTimeTools = new TimeTools();

    foreach ($objORM->FetchAll($SCondition, 'CatId,GroupIdKey,Name,id,ApiId', TableIWWebSub2Menu) as $ListCatId) {
        $ApivarList = $ListCatId->CatId;
        require IW_ASSETS_FROM_PANEL . "include/ApiLoader.php";

        $arrAllApiContent = $objReqular->JsonDecodeArray($objReqular->deBase64($ApiContent));
        $MainCategory = '';

        if ($arrAllApiContent['products'] != null) {

            $SubIdKey = $ListCatId->GroupIdKey;
            $SubCondition = "IdKey = '$SubIdKey' ";
            $STSubMenu = $objORM->Fetch($SubCondition, 'GroupIdKey,Name,id,ApiId', TableIWWebSubMenu);

            $MainIdKey = $STSubMenu->GroupIdKey;
            $MainCondition = "IdKey = '$MainIdKey' ";
            $STMainMenu = $objORM->Fetch($MainCondition, 'Name,ApiId', TableIWWebMainMenu);

            foreach ($arrAllApiContent['products'] as $product) {
                $MainPrice = $product['price']['current']['value'];

                $ProductName = $objReqular->strReplace($product['name'], "'");
                $ProductName = $objReqular->strReplace($ProductName, '"');
                $ProductId = $product['id'];
                $ProductUrl = $product['url'];
                $GroupIdKey = $ListCatId->IdKey;


                $PGender = $STMainMenu->Name;
                $PCategory = $STSubMenu->Name;
                $PGroup = $ListCatId->Name;
                $PGenderId = $STMainMenu->ApiId;
                $PCategoryId = $STSubMenu->ApiId;
                $PGroupId = $ListCatId->ApiId;

                $Enabled = true;
                $SCondition = "   ProductId = $ProductId   ";

                if ($objORM->DataExist($SCondition, TableIWAPIProducts)) {

                    continue;

                } else {

                    $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
                    
                    

                    

                    $now_modify = date("Y-m-d H:i:s");

                    $InSet = "";
                    
                    $InSet .= " Enabled = $Enabled ,";
                    $InSet .= " ProductId = $ProductId ,";
                    $InSet .= " Name = '$ProductName' ,";
                    $InSet .= " PGender = '$PGender' ,";
                    $InSet .= " PCategory = '$PCategory' ,";
                    $InSet .= " PGroup = '$PGroup' ,";
                    $InSet .= " PGenderId = '$PGenderId' ,";
                    $InSet .= " PCategoryId = '$PCategoryId' ,";
                    $InSet .= " PGroupId = '$PGroupId' ,";
                    $InSet .= " GroupIdKey = '$GroupIdKey' ,";
                    $InSet .= " Url = '$ProductUrl' ,";
                    $InSet .= " MainPrice = $MainPrice ,";
                    $InSet .= " modify_ip = '$modify_ip' ,";
                    
                    
                    $InSet .= " last_modify = '$now_modify' ";
                    $objORM->DataAdd($InSet, TableIWAPIProducts);

                }

            }
        }
    }

    $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
    JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
    exit();


}

if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();

    $arrExcept = array('Description' => '');
    if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $Name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Name);
        $GroupIdKey = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->GroupIdKey);
        $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);
        $Enabled = true;
        $SCondition = "Name = '$Name' AND GroupIdKey = '$GroupIdKey'    ";

        if ($objORM->DataExist($SCondition, TableIWWebSubMenu)) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            
            

            

            $now_modify = date("Y-m-d H:i:s");
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));
            $InSet = "";
            
            $InSet .= " Enabled = $Enabled ,";
            $InSet .= " GroupIdKey = '$GroupIdKey' ,";
            $InSet .= " Name = '$Name' ,";
            $InSet .= " Description = '$Description' ,";
            $InSet .= " modify_ip = '$modify_ip' ,";
            
            
            $InSet .= " last_modify = '$now_modify' ,";
            $InSet .= " modify_id = $ModifyId ";

            $objORM->DataAdd($InSet, TableIWWebSubMenu);

            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (!isset($_POST['SubmitApi']) and @$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  id = $IdKey ";
    $objEditView = $objORM->Fetch($SCondition, 'Name,GroupIdKey,Description', TableIWWebSubMenu);

    //Part Name
    $SCondition = "  IdKey = '$objEditView->GroupIdKey' ";
    $Item = $objORM->Fetch($SCondition, 'Name,id', TableIWWebSub2Menu);
    $strMenuIdKey = '<option selected value="' . $Item->id . '">' . $Item->Name . '</option>';
    $SCondition = " Enabled = $Enabled ORDER BY id ";
    foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWWebSub2Menu) as $ListItem) {
        $strMenuIdKey .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
    }


    if (isset($_POST['SubmitM'])) {
        $objAclTools = new ACLTools();
        $arrExcept = array('Description' => '');
        if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {

            $Name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Name);
            $GroupIdKey = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->GroupIdKey);
            $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);

            $SCondition = "( Name = '$Name' AND GroupIdKey = '$GroupIdKey' ) and id!= $IdKey  ";

            if ($objORM->DataExist($SCondition, TableIWWebSubMenu)) {
                JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
                exit();

            } else {

                $objTimeTools = new TimeTools();
                $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
                
                
                $now_modify = date("Y-m-d H:i:s");
                $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

                $UCondition = " id = $IdKey ";
                $USet = "";
                $USet .= " GroupIdKey = '$GroupIdKey' ,";
                $USet .= " Name = '$Name' ,";
                $USet .= " Description = '$Description' ,";
                $USet .= " modify_ip = '$modify_ip' ,";
                
                
                $USet .= " last_modify = '$now_modify' ,";
                $USet .= " modify_id = $ModifyId ";

                $objORM->DataUpdate($UCondition, $USet, TableIWWebSubMenu);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}





