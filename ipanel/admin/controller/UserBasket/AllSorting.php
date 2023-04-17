<?php
//AllBasket.php

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

$Enabled = BoolEnum::BOOL_TRUE();
$strListHead = (new ListTools())->TableHead(array(FA_LC['user_id'], FA_LC["user"], FA_LC["product_id"], FA_LC["product_code"], FA_LC["order_number"], FA_LC["size"], FA_LC["sorting_number"], FA_LC["count_property"], FA_LC["product"], FA_LC["image"]), FA_LC["tools"]);

$ToolsIcons[] = $arrToolsIcon["reverse"];

$strListBody = '';
@$_GET['s'] != null ? $getStart = @$_GET['s'] : $getStart = 0;
@$_GET['e'] != null ? $getEnd = @$_GET['e'] : $getEnd = 100;
$SCondition = "";
if (isset($_POST['SubmitF'])) {


    $ProductCode = @$_POST['ProductCode'];
    $OrderNu = @$_POST['OrderNu'];
    $Size = @$_POST['Size'];


    if ($ProductCode != '')
        $SCondition .= " ProductCode = '$ProductCode' and ";
    if ($OrderNu != '')
        $SCondition .= " OrderNu = '$OrderNu' and ";
    if ($Size != '')
        $SCondition .= " Size = '$Size' and ";
}

$SCondition .= " ChkState = 'bought'  order by IdRow DESC limit " . $getStart . " , " . $getEnd;


foreach ($objORM->FetchAll($SCondition, 'IdRow,UserIdKey,ProductId,ProductCode,OrderNu,Size,SortingNu,Count,ModifyIP,ProductSizeId,IdKey,Enabled', TableIWAUserMainCart) as $ListItem) {


    $SCondition = "IdKey = '$ListItem->UserIdKey'";
    $objUser = @$objORM->Fetch($SCondition, 'Name,IdRow', TableIWUser);
    $ListItem->UserIdKey = $objUser->Name;
    $ListItem->IdRow = $objUser->IdRow;

    $SCondition = "Enabled = '$Enabled' AND  ProductId = '$ListItem->ProductId' ";

    $APIProducts = $objORM->Fetch($SCondition, '*', TableIWAPIProducts);

    $objArrayImage = explode('==::==', $APIProducts->Content);
    $objArrayImage = array_combine(range(1, count($objArrayImage)), $objArrayImage);


    $ListItem->ModifyIP = $APIProducts->Name;
    $ListItem->Url = $APIProducts->Url;

    $intImageCounter = 1;
    foreach ($objArrayImage as $image) {
        if (@strpos($APIProducts->ImageSet, (string)$intImageCounter) === false) {

            unset($objArrayImage[$intImageCounter]);
        }
        $intImageCounter++;
    }
    $objArrayImage = array_values($objArrayImage);


    $urlWSize = explode("?", basename($ListItem->Url));
    $urlWSize = str_replace(basename($ListItem->Url), $ListItem->ProductSizeId . '?' . $urlWSize[1], $ListItem->Url);
    $ListItem->ProductId = '<a target="_blank" href="https://www.asos.com/' . $urlWSize . '">' . $ListItem->ProductId . '</a>';
    $ListItem->ProductSizeId = $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[0], $APIProducts->Name, 120, 'class="main-image"');


    $strPricingPart = '';
    $strSizeSelect = '';
    $intCountSelect = 1;


    $strSizeSelect = $ListItem->Size;
    $ListItem->Count != '' ? $intCountSelect = $ListItem->Count : $intCountSelect = 1;

    $ListItem->SortingNu = '<input type="text" class="sorting_number"  size="16" id="' . $ListItem->IdKey . '" value="' . $ListItem->SortingNu . '">';


    if ($ListItem->Enabled == BoolEnum::BOOL_FALSE()) {
        $ToolsIcons[2] = $arrToolsIcon["inactive"];
    } else {
        $ToolsIcons[2] = $arrToolsIcon["active"];
    }


    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 10, $objGlobalVar->en2Base64($ListItem->IdKey . '::==::' . TableIWAUserMainCart, 0));
}




