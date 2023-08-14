<?php
//WeightModify.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";



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

//weight Name
$str_product_weight = '';
$SCondition = " id > 0 ORDER BY id DESC";
foreach ($objORM->FetchAll($SCondition, 'Weight,id', TableIWWebWeight) as $ListItem) {
    $str_product_weight .= '<option value="' . $ListItem->id . '">' . $ListItem->Weight . '</option>';
}




if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();

    $arrExcept = array('Description' => '','ExtraPrice'=>'');
    if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {


        $iw_product_weight_id = (float)$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->iw_product_weight_id);
        $NormalPrice = (float)$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->NormalPrice);
        $ExtraPrice = (float)$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->ExtraPrice);

        $SCondition = " iw_product_weight_id = $iw_product_weight_id ";

        if ($objORM->DataExist($SCondition, TableIWWebWeightPrice)) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            $now_modify = date("Y-m-d H:i:s");
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

            
            $InSet = " Enabled = 1 ,";
            $InSet .= " iw_product_weight_id = $iw_product_weight_id ,";
            $InSet .= " NormalPrice = $NormalPrice ,";
            $InSet .= " ExtraPrice = $ExtraPrice ,";
            $InSet .= " modify_ip = '$modify_ip' ,";
            $InSet .= " last_modify = '$now_modify' ,";
            $InSet .= " modify_id = $ModifyId ";

            $objORM->DataAdd($InSet, TableIWWebWeightPrice);


            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (@$objGlobalVar->RefFormGet()[0] != null) {
    $id = $objGlobalVar->RefFormGet()[0];

    $objEditView = $objORM->Fetch("  id = $id ", 'iw_product_weight_id,NormalPrice,ExtraPrice', TableIWWebWeightPrice);


        //Weight
        $SCondition = "  id = $objEditView->iw_product_weight_id ";
        $Item = $objORM->Fetch($SCondition, 'Weight,id', TableIWWebWeight);
        $str_product_weight = '<option selected value="' . $Item->id . '">' . $Item->Weight . '</option>';
        $SCondition = " id > 0 ORDER BY id ";
        foreach ($objORM->FetchAll($SCondition, 'Weight,id', TableIWWebWeight) as $ListItem) {
            $str_product_weight .= '<option value="' . $ListItem->id . '">' . $ListItem->Weight . '</option>';
        }

    if (isset($_POST['SubmitM'])) {
        $objAclTools = new ACLTools();

        $arrExcept = array('Description' => '','ExtraPrice'=>'');
        if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {

            $iw_product_weight_id = (float)$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->iw_product_weight_id);
            $NormalPrice = (float)$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->NormalPrice);
            $ExtraPrice = (float)$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->ExtraPrice);

            $SCondition = "iw_product_weight_id = $iw_product_weight_id AND id <> $id  ";

            if ($objORM->DataExist($SCondition, TableIWWebWeightPrice)) {
                JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
                exit();

            } else {


                $objTimeTools = new TimeTools();
                $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
                
                $now_modify = date("Y-m-d H:i:s");
                $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

                $USet = " iw_product_weight_id = $iw_product_weight_id ,";
                $USet .= " NormalPrice = $NormalPrice ,";
                $USet .= " ExtraPrice = $ExtraPrice ,";
                $USet .= " modify_ip = '$modify_ip' ,";
                $USet .= " last_modify = '$now_modify' ,";
                $USet .= " modify_id = $ModifyId ";

                $objORM->DataUpdate(" id = $id ", $USet, TableIWWebWeightPrice);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}






