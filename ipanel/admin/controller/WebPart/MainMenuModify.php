<?php
//MainMenuModify.php

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
$Enabled = BoolEnum::BOOL_TRUE();
$objAclTools = new ACLTools();
$objTimeTools = new TimeTools();



$SCondition = " Enabled = '$Enabled' ORDER BY IdRow ";


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
/*
if (isset($_POST['SubmitApi']) and @$objGlobalVar->RefFormGet()[0] == null) {




    $ApivarList = null;
    $ApiReplacePeriod = 2;
    $ApiGetLive = 0;

    $objReqular = new Regularization();
    $arrAllApiContent = $objReqular->JsonDecodeArray($objReqular->deBase64($AllCategoriesContent));
    $objAsosAssets = new AsosAssets();
    $objMainRoot = $objAsosAssets->RootCaption($arrAllApiContent['navigation']);
    $GId = 0;


    foreach ($objReqular->JsonDecodeArray($objMainRoot) as $MainRoot) {

        $MainRootCaption = $MainRoot;
        $FromApi = 1;
        $Name = $MainRoot;


        $objSubMenu = $arrAllApiContent['navigation'][$GId]['children'][4]['children'];


        $CId = 0;


        foreach ($objSubMenu as $MainRoot2) {

            $subMenuChild = $arrAllApiContent['navigation'][$GId]['children'][4]['children'][$CId];

            $SubRootCaption = $MainRoot2['content']['title'];
                            $strTitle = str_replace('"', "", $strTitle);
                            $strTitle = str_replace("'", "", $strTitle);
            $ApiCategoryId = $MainRoot2['id'];

           // if (array_key_exists($objReqular->STR2Lower($SubRootCaption), FA_LC))
           //     $SubRootCaption = $objReqular->strReplace(FA_LC[$objReqular->STR2Lower($MainRoot2['content']['title'])], $MainRoot2['content']['title'], $MainRoot2['content']['title']);

            $SCondition = "  ApiId = $GId ";
            $GroupIdKey = $objORM->Fetch($SCondition, 'IdKey', TableIWWebMainMenu)->IdKey;

            $SubRootCaption = $objAclTools->strReplace($SubRootCaption,"'");

            $SCondition = "ApiCategoryId = '$ApiCategoryId' AND GroupIdKey = '$GroupIdKey'   ";

            if ($objORM->DataExist($SCondition, TableIWWebSubMenu)) {
                continue;

            } else {


                $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
                $ModifyTime = $objTimeTools->jdate("H:i:s");
                $ModifyDate = $objTimeTools->jdate("Y/m/d");

                $IdKey = $objAclTools->IdKey();

                $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;
                $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminIdKey'));
                $InSet = "";
                $InSet .= " IdKey = '$IdKey' ,";
                $InSet .= " Enabled = '$Enabled' ,";
                $InSet .= " Name = '$SubRootCaption' ,";
                $InSet .= " GroupIdKey = '$GroupIdKey' ,";
                $InSet .= " FromApi = '$FromApi' ,";
                $InSet .= " ApiId = '$CId' ,";
                $InSet .= " ApiCategoryId = '$ApiCategoryId' ,";
                $InSet .= " CompanyIdKey = '4a897b83' ,";
                $InSet .= " ModifyIP = '$ModifyIP' ,";
                $InSet .= " ModifyTime = '$ModifyTime' ,";
                $InSet .= " ModifyDate = '$ModifyDate' ,";
                $InSet .= " ModifyStrTime = '$ModifyStrTime' ,";
                $InSet .= " ModifyId = '$ModifyId' ";

                $objORM->DataAdd($InSet, TableIWWebSubMenu);
            }


            foreach ($subMenuChild['children'] as $subMenuCaption) {
                $ApiCategoryId = $subMenuChild['id'];
                $GrId = 0;
                foreach ($subMenuCaption['children'] as $menuGroupTitle) {

                    $GroupCaption = $menuGroupTitle['content']['title'];
                            $strTitle = str_replace('"', "", $strTitle);
                            $strTitle = str_replace("'", "", $strTitle);
                  //  if (array_key_exists($objReqular->STR2Lower($GroupCaption), FA_LC))
                   //     $GroupCaption = $objReqular->strReplace(FA_LC[$objReqular->STR2Lower($menuGroupTitle['content']['title'])], $menuGroupTitle['content']['title'], $menuGroupTitle['content']['title']);

                    $CatId = $menuGroupTitle['link']['categoryId'];

                    $SCondition = "  ApiCategoryId = '$ApiCategoryId' ";
                    $GroupIdKey = $objORM->Fetch($SCondition, 'IdKey', TableIWWebSubMenu)->IdKey;

                    $GroupCaption = $objAclTools->strReplace($GroupCaption, "'");

                    $SCondition = "CatId = '$CatId' AND GroupIdKey = '$GroupIdKey'   ";

                    if ($objORM->DataExist($SCondition, TableIWWebSub2Menu)) {
                        continue;

                    } else {


                        $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
                        $ModifyTime = $objTimeTools->jdate("H:i:s");
                        $ModifyDate = $objTimeTools->jdate("Y/m/d");

                        $IdKey = $objAclTools->IdKey();


                        $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;
                        $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminIdKey'));
                        $InSet = "";
                        $InSet .= " IdKey = '$IdKey' ,";
                        $InSet .= " Enabled = '$Enabled' ,";
                        $InSet .= " Name = '$GroupCaption' ,";
                        $InSet .= " GroupIdKey = '$GroupIdKey' ,";
                        $InSet .= " FromApi = '$FromApi' ,";
                        $InSet .= " ApiId = '$CId' ,";
                        $InSet .= " CatId = '$CatId' ,";
                        $InSet .= " ModifyIP = '$ModifyIP' ,";
                        $InSet .= " ModifyTime = '$ModifyTime' ,";
                        $InSet .= " ModifyDate = '$ModifyDate' ,";
                        $InSet .= " ModifyStrTime = '$ModifyStrTime' ,";
                        $InSet .= " ModifyId = '$ModifyId' ";

                        $objORM->DataAdd($InSet, TableIWWebSub2Menu);
                    }


                    $GrId++;

                }
            }


            $CId++;

        }


        $GId++;

    }


    $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
    JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
    exit();


}
*/

/*
$SCondition = " CompanyIdKey = '4a897b83' ";
if ($objORM->DataExist($SCondition, TableIWAPIAllData)) {
    $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
    $ModifyTime = $objTimeTools->jdate("H:i:s");
    $ModifyDate = $objTimeTools->jdate("Y/m/d");
    $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;
    $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminIdKey'));

    $UCondition = " CompanyIdKey = '4a897b83' ";
    $USet = "";
    $USet .= " Content = '$AllCategoriesContent' ,";
    $USet .= " ModifyIP = '$ModifyIP' ,";
    $USet .= " ModifyTime = '$ModifyTime' ,";
    $USet .= " ModifyDate = '$ModifyDate' ,";
    $USet .= " ModifyStrTime = '$ModifyStrTime' ,";
    $USet .= " ModifyId = '$ModifyId' ";

    $objORM->DataUpdate($UCondition, $USet, TableIWAPIAllData);

    $USet = "";
    $USet .= " Content = '$AllProductsContent' ,";
    $USet .= " ModifyIP = '$ModifyIP' ,";
    $USet .= " ModifyTime = '$ModifyTime' ,";
    $USet .= " ModifyDate = '$ModifyDate' ,";
    $USet .= " ModifyStrTime = '$ModifyStrTime' ,";
    $USet .= " ModifyId = '$ModifyId' ";

    $objORM->DataUpdate($UCondition, $USet, TableIWAPIAllProducts);

} else {

    $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
    $ModifyTime = $objTimeTools->jdate("H:i:s");
    $ModifyDate = $objTimeTools->jdate("Y/m/d");

    $IdKey = $objAclTools->IdKey();

    $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;
    $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminIdKey'));
    $InSet = "";
    $InSet .= " IdKey = '$IdKey' ,";
    $InSet .= " Enabled = '$Enabled' ,";
    $InSet .= " CompanyIdKey = '4a897b83' ,";
    $InSet .= " ReplacePeriod = 1 ,";
    $InSet .= " Content = '$AllCategoriesContent' ,";
    $InSet .= " ModifyIP = '$ModifyIP' ,";
    $InSet .= " ModifyTime = '$ModifyTime' ,";
    $InSet .= " ModifyDate = '$ModifyDate' ,";
    $InSet .= " ModifyStrTime = '$ModifyStrTime' ,";
    $InSet .= " ModifyId = '$ModifyId' ";

    $objORM->DataAdd($InSet, TableIWAPIAllData);

    $InSet = "";
    $InSet .= " IdKey = '$IdKey' ,";
    $InSet .= " Enabled = '$Enabled' ,";
    $InSet .= " CompanyIdKey = '4a897b83' ,";
    $InSet .= " ReplacePeriod = 1 ,";
    $InSet .= " Content = '$AllProductsContent' ,";
    $InSet .= " ModifyIP = '$ModifyIP' ,";
    $InSet .= " ModifyTime = '$ModifyTime' ,";
    $InSet .= " ModifyDate = '$ModifyDate' ,";
    $InSet .= " ModifyStrTime = '$ModifyStrTime' ,";
    $InSet .= " ModifyId = '$ModifyId' ";

    $objORM->DataAdd($InSet, TableIWAPIAllProducts);



$strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
exit();


}
*/
if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {

    $arrExcept = array('Description' => '');
    if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $Name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Name);
        $LocalName = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->LocalName);
        $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);
        $SCondition = "Name = '$Name'   ";

        if ($objORM->DataExist($SCondition, TableIWWebMainMenu)) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {

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
            $InSet .= " LocalName = '$LocalName' ,";
            $InSet .= " Description = '$Description' ,";
            $InSet .= " ModifyIP = '$ModifyIP' ,";
            $InSet .= " ModifyTime = '$ModifyTime' ,";
            $InSet .= " ModifyDate = '$ModifyDate' ,";
            $InSet .= " ModifyStrTime = '$ModifyStrTime' ,";
            $InSet .= " ModifyId = '$ModifyId' ";

            $objORM->DataAdd($InSet, TableIWWebMainMenu);

            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (!isset($_POST['SubmitApi']) and @$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  IdKey = '$IdKey' ";
    $objEditView = $objORM->Fetch($SCondition, 'Name,LocalName,Description', TableIWWebMainMenu);


    if (isset($_POST['SubmitM'])) {
        $arrExcept = array('Description' => '');
        if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {

            $Name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Name);
            $LocalName = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->LocalName);
            $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);

            $SCondition = "( Name = '$Name'  ) and IdKey != '$IdKey'  ";

            if ($objORM->DataExist($SCondition, TableIWWebMainMenu)) {
                JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
                exit();

            } else {

                $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
                $ModifyTime = $objTimeTools->jdate("H:i:s");
                $ModifyDate = $objTimeTools->jdate("Y/m/d");
                $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;
                $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminIdKey'));

                $UCondition = " IdKey = '$IdKey' ";
                $USet = "";
                $USet .= " Name = '$Name' ,";
                $USet .= " LocalName = '$LocalName' ,";
                $USet .= " Description = '$Description' ,";
                $USet .= " ModifyIP = '$ModifyIP' ,";
                $USet .= " ModifyTime = '$ModifyTime' ,";
                $USet .= " ModifyDate = '$ModifyDate' ,";
                $USet .= " ModifyStrTime = '$ModifyStrTime' ,";
                $USet .= " ModifyId = '$ModifyId' ";

                $objORM->DataUpdate($UCondition, $USet, TableIWWebMainMenu);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}



