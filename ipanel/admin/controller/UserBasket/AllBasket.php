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


$bought_id = $objORM->Fetch("status = 'bought' ", "id", TableIWUserOrderStatus)->id;
$SCondition = " c.iw_user_order_status_id = $bought_id   order by id DESC limit " . $getStart . " , " . $getEnd;

$item_list = " i.* , c.iw_user_order_status_id , c.iw_user_address ";

foreach ($objORM->FetchAll($SCondition, $item_list, TableIWAUserInvoice . " as i left join " . TableIWUserShoppingCart . " as c on c.id = i.shopping_cart_id") as $ListItem) {

    $ListItem->user_id = @$objORM->Fetch("id = $ListItem->user_id", 'Name', TableIWUser)->Name;
    $obj_products = $objORM->Fetch("id = $ListItem->iw_api_products_id ", 'Content,Name,Url', TableIWAPIProducts);
    $ProductVariant = $objORM->Fetch("product_id = $ListItem->product_id ", '*', TableIWApiProductVariants);
    $ListItem->product_id = $ProductVariant->name;
    $ListItem->created_time = $ProductVariant->displaySizeText;

    if (@$obj_products->Content == '')
        continue;

    $objArrayImage = explode('==::==', $obj_products->Content);
    $objArrayImage = array_combine(range(1, count($objArrayImage)), $objArrayImage);

    $ListItem->BasketIdKey = @$obj_products->Name;
    $ListItem->Url = @$obj_products->Url;

    $intImageCounter = 1;
    foreach ($objArrayImage as $image) {
        if (@strpos($obj_products->ImageSet, (string) $intImageCounter) === false) {

            unset($objArrayImage[$intImageCounter]);
        }
        $intImageCounter++;
    }
    $objArrayImage = array_values($objArrayImage);


    $urlWSize = explode("?", basename(@$obj_products->Url));
    $urlWSize = str_replace(basename(@$obj_products->Url), $ProductVariant->product_id . '?' . @$urlWSize[1], @$obj_products->Url);
    $ListItem->product_id = '<a target="_blank" href="https://www.asos.com/' . $urlWSize . '">' . $ProductVariant->name . '</a>';
    $ListItem->promo_code = $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[0], @$obj_products->Name, 120, 'class="main-image"');


    $strPricingPart = '';
    $strSizeSelect = '';
    $intCountSelect = 1;


    $strSizeSelect = $ProductVariant->displaySizeText;
    $ListItem->qty != '' ? $intCountSelect = $ListItem->qty : $intCountSelect = 1;

    $ListItem->qty = '<input type="text" class="order_number"  size="16" id="' . $ListItem->id . '" value="' . $ListItem->qty . '">';


    if ($ListItem->Enabled == false) {
        $ToolsIcons[2] = $arrToolsIcon["inactive"];
    } else {
        $ToolsIcons[2] = $arrToolsIcon["active"];
    }

    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 7, $objGlobalVar->en2Base64($ListItem->id . '::==::' . TableIWAUserMainCart, 0));
}