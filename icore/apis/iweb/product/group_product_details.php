<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../../iassets/include/DBLoader.php";


if (isset($_POST['cat_id'])) {

    $cat_id = $_POST['cat_id'];
    $page_condition = $_POST['page_condition'];
    $condition = "CatId = '$cat_id' and Enabled = 1 " . $page_condition;

    if ($objORM->DataExist($condition, TableIWAPIProducts)) {

        $obj_products = @$objORM->FetchAll($condition, "IdKey,Name,PCategory,PGroup,Content,ImageSet,MainPrice,LastPrice,ProductType", TableIWAPIProducts);


        $objFileToolsInit = new FileTools("../../../idefine/conf/init.iw");
        $objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
        $objShowFile->SetRootStoryFile('../../../irepository/img/');


        $products_diteils = array();

        foreach ($obj_products as $product) {
            $objArrayImage = explode("==::==", $product->Content);
            $objArrayImage = array_combine(range(1, count($objArrayImage)), $objArrayImage);

            $intImageCounter = 1;
            foreach ($objArrayImage as $image) {
                if (@strpos($product->ImageSet, (string) $intImageCounter) === false) {

                    unset($objArrayImage[$intImageCounter]);
                }
                $intImageCounter++;
            }
            $objArrayImage = array_values($objArrayImage);


            $strPricingPart = '';
            $SArgument = "'$product->IdKey','c72cc40d','fea9f1bf'";
            $CarentCurrencyPrice = @$objORM->FetchFunc($SArgument, FuncIWFuncPricing);
            $PreviousCurrencyPrice = @$objORM->FetchFunc($SArgument, FuncIWFuncLastPricing);
            $CarentCurrencyPrice = $CarentCurrencyPrice[0]->Result;
            $PreviousCurrencyPrice = $PreviousCurrencyPrice[0]->Result;

            $boolChange = 0;

            if ($CarentCurrencyPrice != $PreviousCurrencyPrice and $PreviousCurrencyPrice != 0)
                $boolChange = 1;

            if ($CarentCurrencyPrice != null) {
                $CarentCurrencyPrice = $objGlobalVar->NumberFormat($CarentCurrencyPrice, 0, ".", ",");
                $CarentCurrencyPrice = $objGlobalVar->Nu2FA($CarentCurrencyPrice);
                $strPricingPart .= '<h6 class="fw-semibold">' . $CarentCurrencyPrice . 'تومان</h6>';
            }

            if ($PreviousCurrencyPrice != null and $boolChange) {
                $PreviousCurrencyPrice = $objGlobalVar->NumberFormat($PreviousCurrencyPrice, 0, ".", ",");
                $PreviousCurrencyPrice = $objGlobalVar->Nu2FA($PreviousCurrencyPrice);
                $strPricingPart .= '<h6><del>' . $PreviousCurrencyPrice . 'تومان</del></h6>';
            }


            $str_image = $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), $objArrayImage[0], $product->Name, 336, 'class="card-img rounded-0 owl-lazy"', 'data-src');
            $product_content = $product->ProductType . ' ' . $product->PCategory . ' ' . $product->PGroup;

            $arr_product_detail = array('name' => $product->Name, 'product_content' => $product_content, 'image' => $str_image, 'str_price' => $strPricingPart);
            $arr_product_offer = array('offer1' => '<div class="text-bg-light p-1 mb-2"><small>جدید</small></div>');
            $arr_product_note = array('note1' => '<h6 class="m-0">تحویل از راه دور</h6>');
            $arr_product_detials = array_merge($arr_product_detail, $arr_product_offer, $arr_product_note);
            $products_diteils[] = $arr_product_detials;
        }


        echo json_encode($products_diteils);
    } else {
        echo false;
    }

} else {
    echo false;
}