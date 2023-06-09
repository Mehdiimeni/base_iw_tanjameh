<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../../iassets/include/DBLoader.php";

if (!empty($_POST['user_id'])) {
    if (!empty($_POST['products_id'])) {

        $currencies_conversion_id = trim($_POST['currencies_conversion_id']);
        foreach ($_POST['products_id'] as $key => $value) {
            
            $obj_product_variants = @$objORM->Fetch(
                "product_id = $value",
                'displaySizeText,sizeOrder,colour,isInStock,price_current,price_previous,iw_api_products_id,product_id,id',
                TableIWApiProductVariants
            );

            $obj_product = $objORM->Fetch(
                "id = $obj_product_variants->iw_api_products_id",
                "id,Name,Content,ImageSet,url_gender,url_category,url_group,id,iw_product_weight_id,iw_api_brands_id,iw_api_product_type_id",
                TableIWAPIProducts
            );


            $objFileToolsInit = new FileTools("../../../idefine/conf/init.iw");
            $objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
            $objShowFile->SetRootStoryFile('./irepository/img/');


            $obj_product_diteils = array();


            $objArrayImage = explode("==::==", $obj_product->Content);
            $objArrayImage = array_combine(range(1, count($objArrayImage)), $objArrayImage);

            $intImageCounter = 1;
            foreach ($objArrayImage as $image) {
                if (@strpos($obj_product->ImageSet, (string) $intImageCounter) === false) {

                    unset($objArrayImage[$intImageCounter]);
                }
                $intImageCounter++;
            }
            $objArrayImage = array_values($objArrayImage);


            $argument = "$obj_product_variants->id,$currencies_conversion_id";
            $CarentCurrencyPrice = (float) @$objORM->FetchFunc($argument, FuncIWFuncVariantsPricing)[0]->Result;
            $PreviousCurrencyPrice = (float) @$objORM->FetchFunc($argument, FuncIWFuncVariantsLastPricing)[0]->Result;

            $name_currency = $objORM->Fetch(
                "id =" . $objORM->Fetch(
                    "id = $currencies_conversion_id",
                    "iw_currencies_id2",
                    TableIWACurrenciesConversion
                )->iw_currencies_id2,
                "Name",
                TableIWACurrencies
            )->Name;

            //persent
            if ($PreviousCurrencyPrice > $CarentCurrencyPrice) {
                $discount_persent = floor((($PreviousCurrencyPrice - $CarentCurrencyPrice) / $PreviousCurrencyPrice) * 100);
                $discount_persent = $objGlobalVar->Nu2FA($discount_persent);
            } else {
                $discount_persent = 0;
            }

            $boolChange = 0;

            if ($CarentCurrencyPrice != $PreviousCurrencyPrice and $PreviousCurrencyPrice != 0)
                $boolChange = 1;

            if ($discount_persent) {

                if ($CarentCurrencyPrice != null) {
                    $CarentCurrencyPrice = $objGlobalVar->NumberFormat($CarentCurrencyPrice, 0, ".", ",");
                    $CarentCurrencyPrice = $objGlobalVar->Nu2FA($CarentCurrencyPrice);
                    $strPricingPart = '<h4 class="d-inline-block me-2 text-danger prices"><span class="product-price">' . $CarentCurrencyPrice . '</span> ' . $name_currency . '</h4>';
                }
            } else {

                if ($CarentCurrencyPrice != null) {
                    $CarentCurrencyPrice = $objGlobalVar->NumberFormat($CarentCurrencyPrice, 0, ".", ",");
                    $CarentCurrencyPrice = $objGlobalVar->Nu2FA($CarentCurrencyPrice);
                    $strPricingPart = '<h4 class="d-inline-block me-2  prices"><span class="product-price">' . $CarentCurrencyPrice . '</span> ' . $name_currency . '</h4>';
                }

            }

            $strOldPricingPart = 0;

            if ($PreviousCurrencyPrice != null and $boolChange) {
                $PreviousCurrencyPrice = $objGlobalVar->NumberFormat($PreviousCurrencyPrice, 0, ".", ",");
                $PreviousCurrencyPrice = $objGlobalVar->Nu2FA($PreviousCurrencyPrice);
                $strOldPricingPart = '<del class="d-block">' . $PreviousCurrencyPrice . ' ' . $name_currency . '</del>';
            }


            // shipping price

            $strShippingPrice = '';
            $PWIdKey = $obj_product->iw_product_weight_id;

            $objShippingTools = new ShippingTools((new MySQLConnection($objFileToolsDBInfo))->getConn());

            if ($objShippingTools->FindItemWeight($obj_product) == -1) {
                $product_weight = 2;
                $objORM->DataUpdate("id = $obj_product->id", " NoWeightValue = 1 ", TableIWAPIProducts);
            } else {

                $product_weight = $objShippingTools->FindItemWeight($obj_product);
            }


            $intTotalShipping = $objShippingTools->FindBasketWeightPrice($product_weight, $obj_product_variants->price_current, $currencies_conversion_id);

            if ($intTotalShipping != 0) {
                $intTotalShipping = $objGlobalVar->NumberFormat($intTotalShipping, 0, ".", ",");
                $strShippingPrice = $objGlobalVar->Nu2FA($intTotalShipping) . $name_currency;
            }

            // wieght

            $strShippingWeight = $product_weight . ' KG ';


            $obj_product_page_url = "?gender=" . urlencode($obj_product->url_gender) . "&category=" . urlencode($obj_product->url_category) . "&group=" . urlencode($obj_product->url_group) . "&item=" . $obj_product->id;

            $images_address = array();
            foreach ($objArrayImage as $image) {
                $images_address[] = $objShowFile->FileLocation("attachedimage") . $image;
            }

            $obj_brand_name = @$objORM->Fetch("id = $obj_product->iw_api_brands_id ", 'name,id', TableIWApiBrands);
            $obj_product_type = @$objORM->Fetch("id = $obj_product->iw_api_product_type_id ", 'name,id', TableIWApiProductType);

            $objShowFile->ShowImage('../../../../', $objShowFile->FileLocation("attachedimage"), $objArrayImage[0], $obj_product->Name, 336, '');
            $image_one_address = $objShowFile->FileLocation("attachedimage") . 'thumbnail/' . $objShowFile->NameChSize($objShowFile->FileLocation("attachedimage"), $objArrayImage[0], 336);

            $arr_product_detail[] = array(
                'name' => $obj_product->Name,
                'id' => $obj_product->id,
                'images_address' => $image_one_address,
                'price' => $CarentCurrencyPrice,
                'old_price' => $PreviousCurrencyPrice,
                'product_page_url' => $obj_product_page_url,
                'size' => $obj_product_variants->displaySizeText,
                'sizeOrder' => $obj_product_variants->sizeOrder,
                'product_id' => $obj_product_variants->product_id,
                'colour' => $obj_product_variants->colour,
                'discount_persent' => $discount_persent,
                'name_currency' => $name_currency,
                'product_type' => $obj_product_type->name,
                'brand_name' => $obj_brand_name->name,
                'shipping_price' => $strShippingPrice,
                'shipping_weight' => $strShippingWeight
            );

           


        }

        echo json_encode($arr_product_detail);

    } else {
        echo false;
    }

} else {
    echo false;
}