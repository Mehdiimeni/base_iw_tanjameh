<?php
//AllBasket.php

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

$Enabled = BoolEnum::BOOL_TRUE();
$strListHead = (new ListTools())->TableHead(array(FA_LC["row"], FA_LC["id"], FA_LC["user"], FA_LC["product"],FA_LC["product_code"], FA_LC["image"], FA_LC["size"], FA_LC["count_property"], FA_LC["date"], FA_LC["order_number"]), FA_LC["tools"]);


$strListBody = '';
@$_GET['s'] != null ? $getStart = @$_GET['s'] : $getStart = 0;
@$_GET['e'] != null ? $getEnd = @$_GET['e'] : $getEnd = 100;

$SCondition = " ChkState = 'none'  order by IdRow DESC limit " . $getStart . " , " . $getEnd;


foreach ($objORM->FetchAll($SCondition, 'IdRow,IdKey,UserIdKey,BasketIdKey,ProductId,ProductSizeId,Size,Count,ModifyDate,OrderNu,Enabled', TableIWAUserMainCart) as $ListItem) {


    $SCondition = "IdKey = '$ListItem->UserIdKey'";
    $ListItem->UserIdKey = @$objORM->Fetch($SCondition, 'Name', TableIWUser)->Name;


    $SCondition = "Enabled = '$Enabled' AND  ProductId = '$ListItem->ProductId' ";

    $APIProducts = $objORM->Fetch($SCondition, '*', TableIWAPIProducts);

    $objArrayImage = explode('==::==', @$APIProducts->Content);
    $objArrayImage = array_combine(range(1, count($objArrayImage)), $objArrayImage);

    $ListItem->BasketIdKey = @$APIProducts->Name;
    $ListItem->Url = @$APIProducts->Url;

    $intImageCounter = 1;
    foreach ($objArrayImage as $image) {
        if (@strpos($APIProducts->ImageSet, (string)$intImageCounter) === false) {

            unset($objArrayImage[$intImageCounter]);
        }
        $intImageCounter++;
    }
    $objArrayImage = array_values($objArrayImage);


    $urlWSize = explode("?", basename(@$ListItem->Url));
    $urlWSize = str_replace(basename(@$ListItem->Url), $ListItem->ProductSizeId . '?' . @$urlWSize[1], @$ListItem->Url);
    $ListItem->BasketIdKey = '<a target="_blank" href="https://www.asos.com/' . $urlWSize . '">' . $ListItem->BasketIdKey . '</a>';
    $ListItem->ProductSizeId = $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[0], @$APIProducts->Name, 120, 'class="main-image"');


    $strPricingPart = '';
    $strSizeSelect = '';
    $intCountSelect = 1;


    $strSizeSelect = $ListItem->Size;
    $ListItem->Count != '' ? $intCountSelect = $ListItem->Count : $intCountSelect = 1;

    $ListItem->OrderNu = '<input type="text" class="order_number"  size="16" id="' . $ListItem->IdKey . '" value="' . $ListItem->OrderNu. '">';


    if ($ListItem->Enabled == BoolEnum::BOOL_FALSE()) {
        $ToolsIcons[2] = $arrToolsIcon["inactive"];
    } else {
        $ToolsIcons[2] = $arrToolsIcon["active"];
    }

    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 10, $objGlobalVar->en2Base64($ListItem->IdKey . '::==::' . TableIWAUserMainCart, 0));
}




