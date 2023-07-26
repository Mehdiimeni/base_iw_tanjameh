<?php
//AllBasket.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

$Enabled = true;
$strListHead = (new ListTools())->TableHead(array(FA_LC["user"], FA_LC["product"], FA_LC["image"], FA_LC["size"], FA_LC["count_property"], FA_LC["date"], FA_LC["order_number"]), FA_LC["tools"]);


$strListBody = '';
@$_GET['s'] != null ? $getStart = @$_GET['s'] : $getStart = 0;
@$_GET['e'] != null ? $getEnd = @$_GET['e'] : $getEnd = 100;


$item_list = " user_name, product_name, images, size_text, qty, last_modify,id,product_id,url,  Enabled ";
foreach ($objORM->FetchAll("status = 'bought'", $item_list, ViewIWUserCart) as $ListItem) {


    $objArrayImage = explode('==::==', $ListItem->images);
    $objArrayImage = array_combine(range(1, count($objArrayImage)), $objArrayImage);

    $urlWSize = explode("?", basename($ListItem->url));
    $urlWSize = str_replace(basename($ListItem->url), $ListItem->product_id . '?' . @$urlWSize[1], $ListItem->url);
    $ListItem->product_name = '<a target="_blank" href="https://www.asos.com/' . $urlWSize . '">' . $ListItem->product_name . '</a>';
    $ListItem->images = @$objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[0], @$ListItem->product_name, 120, 'class="main-image"');

    $ListItem->qty = '<input type="text" class="order_number"  size="16" id="' . $ListItem->id . '" value="' . $ListItem->qty . '">';


    if ($ListItem->Enabled == false) {
        $ToolsIcons[2] = $arrToolsIcon["inactive"];
    } else {
        $ToolsIcons[2] = $arrToolsIcon["active"];
    }

    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 7, $objGlobalVar->en2Base64($ListItem->id . '::==::' . TableIWAUserMainCart, 0));
}