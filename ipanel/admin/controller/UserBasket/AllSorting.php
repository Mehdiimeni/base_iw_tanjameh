<?php
//AllBasket.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

$Enabled = true;
$strListHead = (new ListTools())->TableHead(array(FA_LC["user"], FA_LC["product"], FA_LC["image"], FA_LC["size"], FA_LC["barcode_number"], FA_LC["count_property"], FA_LC["date"], FA_LC["order_number"]), FA_LC["tools"]);

$ToolsIcons[] = $arrToolsIcon["reverse"];

$strListBody = '';
@$_GET['s'] != null ? $getStart = @$_GET['s'] : $getStart = 0;
@$_GET['e'] != null ? $getEnd = @$_GET['e'] : $getEnd = 100;
$SCondition = "";
if (isset($_POST['SubmitF'])) {


    $product_code = @$_POST['product_code'];
    $id = @$_POST['id'];
    $size = @$_POST['size'];


    if ($product_code != '')
        $SCondition .= " product_code = $product_code and ";
    if ($qty != '')
        $SCondition .= " id = $id and ";
    if ($size != '')
        $SCondition .= " size = '$size' and ";
}

$SCondition .= " status = 'bought' or status = 'preparation'  order by id DESC limit " . $getStart . " , " . $getEnd;
$item_list = " user_name, product_name, images, size_text,barcode_number, qty, last_modify,id,product_id,url,user_id,user_address,user_shopping_cart_id,Enabled ";


foreach ($objORM->FetchAll($SCondition, $item_list, ViewIWUserCart) as $ListItem) {


    if (!$objORM->DataExist("main_cart_id = $ListItem->id  and user_id = $ListItem->user_id and product_id", TableIWShippingProduct)) {
        $in_set = " user_id = $ListItem->user_id, product_id = $ListItem->product_id,
        cart_id = $ListItem->user_shopping_cart_id,size = '$ListItem->size_text' ,
        address_id = $ListItem->user_address,main_cart_id = $ListItem->id ";
        $objORM->DataAdd($in_set, TableIWShippingProduct);
        $shipping_product_id = $objORM->LastId();
    } else {

        $shipping_product_id = $objORM->Fetch("main_cart_id = $ListItem->id  and user_id = $ListItem->user_id and product_id", "id", TableIWShippingProduct)->id;
    }


    $objArrayImage = explode('==::==', $ListItem->images);
    $objArrayImage = array_combine(range(1, count($objArrayImage)), $objArrayImage);

    $urlWSize = explode("?", basename($ListItem->url));
    $urlWSize = str_replace(basename($ListItem->url), $ListItem->product_id . '?' . @$urlWSize[1], $ListItem->url);
    $ListItem->product_name = '<a target="_blank" href="https://www.asos.com/' . $urlWSize . '">' . $ListItem->product_name . '</a>';
    $ListItem->images = @$objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[0], @$ListItem->product_name, 120, 'class="main-image"');


    $ListItem->barcode_number = '<input type="text" class="barcode_number" data-cart="'.$ListItem->user_shopping_cart_id.'"  size="16" id="' . $shipping_product_id . '" value="' . $ListItem->barcode_number . '">';


    if ($ListItem->Enabled == false) {
        $ToolsIcons[2] = $arrToolsIcon["inactive"];
    } else {
        $ToolsIcons[2] = $arrToolsIcon["active"];
    }


    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 8, $objGlobalVar->en2Base64($ListItem->id . '::==::' . TableIWAUserMainCart, 0));
}