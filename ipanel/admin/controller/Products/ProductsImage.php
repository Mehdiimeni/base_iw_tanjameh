<?php
//ProductsImage.php

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$Enabled = BoolEnum::BOOL_TRUE();
$strListHead = (new ListTools())->TableHead(array(FA_LC["row"], FA_LC["characteristic"], FA_LC["image"], FA_LC["category"], FA_LC["view"]), FA_LC["tools"]);

// API Count and Connect
$objAsos = new AsosConnections();


$objReqular = new Regularization();


$ToolsIcons[] = $arrToolsIcon["view"];
$ToolsIcons[] = $arrToolsIcon["edit"];
$ToolsIcons[] = $arrToolsIcon["active"];
$ToolsIcons[] = $arrToolsIcon["delete"];

//image
$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

$objStorageTools = new StorageTools($objFileToolsInit->KeyValueFileReader()['MainName']);
$objStorageTools->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');


if (@$_GET['new'] == 1) {

    $_GET['size'] != null ? $limit = $_GET['size'] : $limit = '3';

    $intCountLoop = 1;
    foreach ($objORM->FetchLimit('Content IS NULL', 'ProductId', 'IdKey DESC', $limit, TableIWAPIProducts) as $ListItemNew) {


        $ApivarList = $ListItemNew->ProductId;
        $ApiCategoryName = 'ProductsDetail';
        $ApiReplacePeriod = 2;
        $ApiGetLive = 1;
        require IW_ASSETS_FROM_PANEL . "include/ApiLoader.php";

        $arrApiProductDetail = $objReqular->JsonDecodeArray($objReqular->deBase64($ApiContent));
        if (!isset($arrApiProductDetail['errorCode'])) {
            if (count($arrApiProductDetail['media']['images']) > 0) {

                $arrImage = array();

                foreach ($arrApiProductDetail['media']['images'] as $ProductImage) {

                    $ch = curl_init('https://' . $ProductImage['url'] . '?wid=1080');
                    $fp = fopen(IW_REPOSITORY_FROM_PANEL . 'tmp/img/product/product.jpg', 'wb');
                    curl_setopt($ch, CURLOPT_FILE, $fp);
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_exec($ch);
                    curl_close($ch);
                    fclose($fp);


                    $FileExt = $objStorageTools->FindFileExt('', IW_REPOSITORY_FROM_PANEL . 'tmp/img/product/product.jpg');
                    if (!$objStorageTools->FileAllowFormat(FileSizeEnum::ExtImage(), $FileExt)) {

                        continue;
                        exit();
                    }
                    if (!$objStorageTools->FileAllowSize('attachedimage', IW_REPOSITORY_FROM_PANEL . 'tmp/img/product/product.jpg')) {

                        continue;
                        exit();
                    }

                    $FileNewName = $objStorageTools->FileSetNewName($FileExt);
                    $arrImage[] = $FileNewName;

                    $objStorageTools->ImageOptAndStorage(IW_REPOSITORY_FROM_PANEL . 'tmp/img/product/product.jpg', 'attachedimage', $FileNewName);

                }
                $strImages = implode("==::==", $arrImage);
                $UCondition = " ProductId = '$ApivarList' ";
                $USet = "Content = '$strImages'";
                $objORM->DataUpdate($UCondition, $USet, TableIWAPIProducts);

            }
        } else {
            continue;
        }
        $intCountLoop++;


        $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;

        if ($intCountLoop > 3 and $objORM->DataExist('Content IS NULL', TableIWAPIProducts)) {
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }

    }
}

if (@$_GET['new'] == 'all') {

    foreach ($objORM->FetchAll('Content IS NOT NULL', 'ProductId', TableIWAPIProducts) as $ListItemNew) {


        $ApivarList = $ListItemNew->ProductId;
        $ApiCategoryName = 'ProductsDetail';
        $ApiReplacePeriod = 2;
        $ApiGetLive = 1;
        require IW_ASSETS_FROM_PANEL . "include/ApiLoader.php";

        $arrApiProductDetail = $objReqular->JsonDecodeArray($objReqular->deBase64($ApiContent));

        if (count($arrApiProductDetail['media']['images']) > 0) {

            $arrImage = array();

            foreach ($arrApiProductDetail['media']['images'] as $ProductImage) {

                $content = file_get_contents('https://' . $ProductImage['url'] . '?wid=1400');
                $fp = fopen(IW_REPOSITORY_FROM_PANEL . 'tmp/img/product/product.jpg', "w");
                fwrite($fp, $content);
                fclose($fp);

                $FileExt = $objStorageTools->FindFileExt('', IW_REPOSITORY_FROM_PANEL . 'tmp/img/product/product.jpg');
                if (!$objStorageTools->FileAllowFormat(FileSizeEnum::ExtImage(), $FileExt)) {

                    JavaTools::JsAlertWithRefresh(FA_LC['enter_format_file_error'], 0, '');
                    exit();
                }
                if (!$objStorageTools->FileAllowSize('attachedimage', IW_REPOSITORY_FROM_PANEL . 'tmp/img/product/product.jpg')) {

                    JavaTools::JsAlertWithRefresh(FA_LC['enter_size_file_error'], 0, '');
                    exit();
                }

                $FileNewName = $objStorageTools->FileSetNewName($FileExt);
                $arrImage[] = $FileNewName;

                $objStorageTools->ImageOptAndStorage(IW_REPOSITORY_FROM_PANEL . 'tmp/img/product/product.jpg', 'attachedimage', $FileNewName);

            }
            $strImages = implode("==::==", $arrImage);
            $UCondition = " ProductId = '$ApivarList' ";
            $USet = "Content = '$strImages'";
            $objORM->DataUpdate($UCondition, $USet, TableIWAPIProducts);


        }


        $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
        JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));

    }
}


$strListBody = '';
foreach ($objORM->FetchAll('Content IS NOT NULL and ModifyId IS NOT NULL and AdminOk = 1', 'IdKey,ProductId,Content,PGender,PCategory,PGroup,ModifyId,Enabled,IdRow', TableIWAPIProducts) as $ListItem) {


    $ListItem->ModifyId == null ? $ListItem->ModifyId = FA_LC["no_viewed"] : FA_LC["viewed"];
    $objArrayImage = explode("==::==", $ListItem->Content);

    $ListItem->Content = '';
    foreach ($objArrayImage as $image) {
        $ListItem->Content .= $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), $image, $ListItem->ProductId, 120, '');
    }


    if ($ListItem->Enabled == BoolEnum::BOOL_FALSE()) {
        $ToolsIcons[2] = $arrToolsIcon["inactive"];
    } else {
        $ToolsIcons[2] = $arrToolsIcon["active"];
    }

    if (@$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJsonNoSet())->act != 'move') {

        $ToolsIcons[4] = $arrToolsIcon["move"];

    } elseif ($objGlobalVar->JsonDecode($objGlobalVar->GetVarToJsonNoSet())->act == 'move' and @$objGlobalVar->RefFormGet()[0] == $ListItem->IdKey) {
        $ToolsIcons[4] = $arrToolsIcon["movein"];
        $ToolsIcons[5] = $arrToolsIcon["closemove"];
        $objGlobalVar->setGetVar('chin', $ListItem->IdRow);


    } else {

        $ToolsIcons[4] = $arrToolsIcon["moveout"];
        $urlAppend = $ToolsIcons[4][3] . '&chto=' . $ListItem->IdRow . '&chin=' . @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->chin;
        $ToolsIcons[4][3] = $urlAppend;

    }
    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 5, $objGlobalVar->en2Base64($ListItem->IdKey . '::==::' . TableIWAPIProducts, 0));


}




