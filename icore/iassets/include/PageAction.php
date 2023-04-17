<?php
//PageAction.php

require IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
require_once IW_DEFINE_FROM_PANEL . "queryset/ProductShopState.php";

//Exit
if (@$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->act == 'logout') {
    if (@$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->q == 'y') {


        $objTimeTools = new TimeTools();
        $Online = BoolEnum::BOOL_FALSE();
        $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
        $ModifyTime = $objTimeTools->jdate("H:i:s");
        $ModifyDate = $objTimeTools->jdate("Y/m/d");

        $ModifyStrTime = $objGlobalVar->JsonDecode($objTimeTools->getDateTimeNow())->date;
        if (@$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->type == 'adm') {
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminIdKey'));
        } else {
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));
        }
        $InSet = "";
        $InSet .= " Online = '$Online' ,";
        $InSet .= " ModifyIP = '$ModifyIP' ,";
        $InSet .= " ModifyTime = '$ModifyTime' ,";
        $InSet .= " ModifyDate = '$ModifyDate' ,";
        $InSet .= " ModifyStrTime = '$ModifyStrTime' ,";
        $InSet .= " ModifyId = '$ModifyId' ";

        if (@$_REQUEST['type'] == 'usr') {
            $objORM->DataAdd($InSet, TableIWUserObserver);
            $FOpen = fopen(IW_REPOSITORY_FROM_PANEL . 'log/login/user/' . $ModifyId . '.iw', 'a+');
        } else {
            $objORM->DataAdd($InSet, TableIWAdminObserver);
            $FOpen = fopen(IW_REPOSITORY_FROM_PANEL . 'log/login/admin/' . $ModifyId . '.iw', 'a+');
        }

        fwrite($FOpen, "$ModifyId==::==$ModifyStrTime==::==out\n");
        fclose($FOpen);

        (new IPTools(IW_DEFINE_FROM_PANEL))->Destroyer();

        $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
        $objGlobalVar->setGetVarNull();

        if (@$_REQUEST['type'] == 'adm') {

            $objGlobalVar->setCookieVarUserNull('_IWAdminIdKey');

        } else {
            $objGlobalVar->setCookieVarUserNull('_IWUserIdKey');
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
        $IdKey = $objGlobalVar->RefFormGet()[0];
        $UCondition = " IdKey='$IdKey'  ";
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
        $IdKey = $objGlobalVar->RefFormGet()[0];
        $UCondition = " IdKey='$IdKey'  ";
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
        $IdKey = $objGlobalVar->RefFormGet()[0];
        $DCondition = " IdKey = '$IdKey'  ";
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
        $IdKey = $objGlobalVar->RefFormGet()[0];

        $SCondition = "IdKey='$IdKey'";
        $currentStateValue = $objORM->Fetch($SCondition, 'ChkState', $objGlobalVar->RefFormGet()[1])->ChkState;

        $currentStateKey = array_search($currentStateValue, ARR_PRODUCT_SHOP_STATE);
        if($currentStateKey != 0 )
        {
            $newStateKey = $currentStateKey - 1;
            $newStateValue = ARR_PRODUCT_SHOP_STATE[$newStateKey];

            $UCondition = " IdKey='$IdKey'  ";
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
        $IdKey = $objGlobalVar->RefFormGet()[0];

        $SCondition = "IdKey='$IdKey'";
        $objCurrentState = $objORM->Fetch($SCondition, 'ChkState,BasketIdKey', $objGlobalVar->RefFormGet()[1]);

        $currentStateKey = array_search($objCurrentState->ChkState, ARR_PRODUCT_SHOP_STATE);
        if($currentStateKey != 0 )
        {
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

