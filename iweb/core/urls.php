<?php
//url.php

if (@$_GET['part'] == null) {


    if (@$_GET['Category'] != null) {
        (new FileCaller)->FileIncluderWithControler(dirname(__FILE__, 1) . "/iweb/", 'Product', 'Category');
        exit();
    }



    if (@$_GET['Search'] != null) {
        (new FileCaller)->FileIncluderWithControler(IW_MAIN_ROOT_FROM_PANEL . IW_WEB_FOLDER, 'Product', 'Search');
        exit();
    }


    if (@$_GET['gender'] != null) {
        include_once(dirname(__FILE__, 2) . "/page/gender.php");
        exit();
    }

    include_once(dirname(__FILE__, 2) . "/page/index.php");
    exit();

} else {


    $strPart = $objGlobalVar->CleanUrlDirMaker(@$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->part);
    $strPage = $objGlobalVar->CleanUrlDirMaker(@$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->page);
    $strModify = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJsonNoSet())->modify;
    if ($strPart != null and $strPage != null) {
        if ($strModify == null) {
            (new FileCaller)->FileIncluderWithControler(IW_MAIN_ROOT_FROM_PANEL . IW_WEB_FOLDER, $strPart, $strPage);
        } else {
            (new FileCaller)->FileModifyIncluderWithControler(IW_MAIN_ROOT_FROM_PANEL . IW_WEB_FOLDER, $strPart, $strPage, $strModify);
        }
    } else {
        (new FileCaller)->FileIncluderWithControler(dirname(__FILE__, 1) . "/iweb/", 'First', 'First');
    }
    exit();

}