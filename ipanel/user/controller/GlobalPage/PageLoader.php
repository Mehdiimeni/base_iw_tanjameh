<?php
include IW_ASSETS_FROM_PANEL."include/PageAction.php";

if (@$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->part == null) {
    (new FileCaller)->FileIncluderWithControler(IW_PANEL_FROM_PANEL . 'user/', 'First', 'First');
    exit();
} else {

    $strPart = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->part;
    $strPage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->page;
    $strModify = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJsonNoSet())->modify;
    if ($strModify == null) {
        (new FileCaller)->FileIncluderWithControler(IW_PANEL_FROM_PANEL . 'user/', $strPart, $strPage);
    } else {
        (new FileCaller)->FileModifyIncluderWithControler(IW_PANEL_FROM_PANEL . 'user/', $strPart, $strPage, $strModify);
    }
    exit();

}