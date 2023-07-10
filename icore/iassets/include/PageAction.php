<?php
//PageAction.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
require_once IW_DEFINE_FROM_PANEL . "queryset/ProductShopState.php";

//Exit
if (@$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->act == 'logout') {
    if (@$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->q == 'y') {


        $objTimeTools = new TimeTools();
        $Online = false;

        $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
        $now_modify = date("Y-m-d H:i:s");

        if (@$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->type == 'adm') {
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));
        } else {
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserId'));
        }
        $InSet = "";
        $InSet .= " Online = $Online ,";
        $InSet .= " modify_ip = '$modify_ip' ,";
        $InSet .= " modify_id = $ModifyId ";
        

        if (@$_REQUEST['type'] == 'usr') {
            $InSet .= ", iw_user_id = $ModifyId ";
            $objORM->DataAdd($InSet, TableIWUserObserver);
            $FOpen = fopen(IW_REPOSITORY_FROM_PANEL . 'log/login/user/' . $ModifyId . '.iw', 'a+');
        } else {
            $InSet .= ", iw_admin_id = $ModifyId ";
            $objORM->DataAdd($InSet, TableIWAdminObserver);
            $FOpen = fopen(IW_REPOSITORY_FROM_PANEL . 'log/login/admin/' . $ModifyId . '.iw', 'a+');
        }

        fwrite($FOpen, "$ModifyId==::==$now_modify==::==out\n");
        fclose($FOpen);

        (new IPTools(IW_DEFINE_FROM_PANEL))->Destroyer();

        $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
        $objGlobalVar->setGetVarNull();

        if (@$_REQUEST['type'] == 'adm') {

            $objGlobalVar->setCookieVarUserNull('_IWAdminId');

        } else {
            $objGlobalVar->setCookieVarUserNull('_IWUserId');
        }

        JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage));
        exit();
    }
    $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
    JavaTools::JsConfirm(FA_LC["exit_tip"], $objGlobalVar->setGetVar('q', 'y'), $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('act', 'q')));
}

// Inactive
if (@$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->act == 'inactive') {
    if (@$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->q == 'y') {
        $UCondition = "id=".$objGlobalVar->RefFormGet()[0];
        $USet = " Enabled = 0  ";
        $objORM->DataUpdate($UCondition, $USet, $objGlobalVar->RefFormGet()[1]);
        $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
        JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('act', 'q')));
        exit();
    }

    $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
    JavaTools::JsConfirm(FA_LC["disable_tip"], $objGlobalVar->setGetVar('q', 'y'), $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('act', 'q')));
}

// Active
if (@$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->act == 'active') {
    if (@$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->q == 'y') {
        $UCondition = "id=".$objGlobalVar->RefFormGet()[0];
        $USet = " Enabled = 1  ";
        $objORM->DataUpdate($UCondition, $USet, $objGlobalVar->RefFormGet()[1]);
        $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
        JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('act', 'q')));
        exit();
    }
    $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
    JavaTools::JsConfirm(FA_LC["enable_tip"], $objGlobalVar->setGetVar('q', 'y'), $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('act', 'q')));
}

// Delete
if (@$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->act == 'del') {
    if (@$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->q == 'y') {
        $DCondition = "id=".$objGlobalVar->RefFormGet()[0];
        $objORM->DeleteRow($DCondition, $objGlobalVar->RefFormGet()[1]);
        $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
        JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('act', 'q')));
        exit();
    }
    $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
    JavaTools::JsConfirm(FA_LC["delete_tip"], $objGlobalVar->setGetVar('q', 'y'), $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('act', 'q')));
}

// Move
if (@$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJsonNoSet())->act == 'moveout') {

    $objORM->Move($objGlobalVar->JsonDecode($objGlobalVar->GetVarToJsonNoSet())->chin, $objGlobalVar->JsonDecode($objGlobalVar->GetVarToJsonNoSet())->chto, $objGlobalVar->RefFormGet()[1]);
    $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
    JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('act', 'q', 'chto', 'chin'))));
    exit();

}

// Inactive API
if (@$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->act == 'inactiveapi') {
    if (@$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->q == 'y') {
        /*
                $IdKey = $objGlobalVar->RefFormGet()[0];
                $apiMainName = $objGlobalVar->RefFormGet()[1];
                $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
                $objRNLS2 = new RNLS2Connection($objFileToolsInit->KeyValueFileReader()['MainApi'] . $apiMainName . "/" . $IdKey, "");
                $arrPatch = array('IsActive' => false);
                $JsonPatchData = $objGlobalVar->JsonEncode($arrPatch);
                $objRNLS2->Patch($JsonPatchData);
                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
        */
        //JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('act', 'q')));
        //  exit();
    }

    //  $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
    // JavaTools::JsConfirm(FA_LC["disable_tip"], $objGlobalVar->setGetVar('q', 'y'), $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('act', 'q')));
}

// Active API
if (@$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->act == 'activeapi') {
    if (@$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->q == 'y') {
        /*  $IdKey = $objGlobalVar->RefFormGet()[0];
          $apiMainName = @$objGlobalVar->RefFormGet()[1];
          $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
          $objRNLS2 = new RNLS2Connection($objFileToolsInit->KeyValueFileReader()['MainApi'] . $apiMainName . "/" . $IdKey, "");
          $arrPatch = array('IsActive' => true);
          $JsonPatchData = $objGlobalVar->JsonEncode($arrPatch);
          $objRNLS2->Patch($JsonPatchData);
          $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln; */
        //  JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('act', 'q')));
        // exit();
    }
    // $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
    // JavaTools::JsConfirm(FA_LC["enable_tip"], $objGlobalVar->setGetVar('q', 'y'), $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('act', 'q')));
}

// reverse action

if (@$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->act == 'reverse') {
    if (@$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->q == 'y') {
    
        $SCondition = "id=".$objGlobalVar->RefFormGet()[0];
        $currentStateValue = $objORM->Fetch($SCondition, 'ChkState', $objGlobalVar->RefFormGet()[1])->ChkState;

        $currentStateKey = array_search($currentStateValue, ARR_PRODUCT_SHOP_STATE);
        if ($currentStateKey != 0) {
            $newStateKey = $currentStateKey - 1;
            $newStateValue = ARR_PRODUCT_SHOP_STATE[$newStateKey];

            $UCondition = "id=".$objGlobalVar->RefFormGet()[0];
            $USet = " ChkState = '$newStateValue'  ";
            $objORM->DataUpdate($UCondition, $USet, $objGlobalVar->RefFormGet()[1]);
        }


        $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
        JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('act', 'q')));
        exit();
    }

    $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
    JavaTools::JsConfirm(FA_LC["reverse_tip"], $objGlobalVar->setGetVar('q', 'y'), $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('act', 'q')));
}

// reverse basket action

if (@$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->act == 'reverse_basket') {
    if (@$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->q == 'y') {

        $SCondition = "id=".$objGlobalVar->RefFormGet()[0];
        $objCurrentState = $objORM->Fetch($SCondition, 'ChkState,BasketIdKey', $objGlobalVar->RefFormGet()[1]);

        $currentStateKey = array_search($objCurrentState->ChkState, ARR_PRODUCT_SHOP_STATE);
        if ($currentStateKey != 0) {
            $newStateKey = $currentStateKey - 1;
            $newStateValue = ARR_PRODUCT_SHOP_STATE[$newStateKey];

            $UCondition = " BasketIdKey='$objCurrentState->BasketIdKey'  ";
            $USet = " ChkState = '$newStateValue'  ";
            $objORM->DataUpdate($UCondition, $USet, $objGlobalVar->RefFormGet()[1]);
        }


        $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
        JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('act', 'q')));
        exit();
    }

    $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
    JavaTools::JsConfirm(FA_LC["reverse_tip"], $objGlobalVar->setGetVar('q', 'y'), $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('act', 'q')));
}