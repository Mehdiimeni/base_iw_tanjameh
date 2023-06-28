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
    $condition = "CatId = '$cat_id' and Enabled = 1 AND Content IS NOT NULL
    AND AdminOk = 1   " . $page_condition;


    if ($objORM->DataExist($condition, TableIWAPIProducts)) {

        $obj_products = @$objORM->FetchAll($condition, "IdRow,IdKey,Name,PGender,PCategory,PGroup,Content,ImageSet,MainPrice,LastPrice,ProductType,Size", TableIWAPIProducts);

        $objFileToolsInit = new FileTools("../../../idefine/conf/init.iw");
        $objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
        $objShowFile->SetRootStoryFile('../irepository/img/');


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
            $SArgument = "'$product->IdRow','c72cc40d','fea9f1bf'";
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
                $strPricingPart = '<h6 class="fw-semibold">' . $CarentCurrencyPrice . 'تومان</h6>';
            }

            $strOldPricingPart = 0;

            if ($PreviousCurrencyPrice != null and $boolChange) {
                $PreviousCurrencyPrice = $objGlobalVar->NumberFormat($PreviousCurrencyPrice, 0, ".", ",");
                $PreviousCurrencyPrice = $objGlobalVar->Nu2FA($PreviousCurrencyPrice);
                $strOldPricingPart = '<h6><del>' . $PreviousCurrencyPrice . 'تومان</del></h6>';
            }


            $product_page_url = "?gender=" . $product->PGender . "&category=" . $product->PCategory . "&group=" . $product->PGroup . "&item=" . $product->IdRow;
            $objShowFile->ShowImage('../../../../', $objShowFile->FileLocation("attachedimage"), $objArrayImage[0], $product->Name, 336, 'class="card-img rounded-0 owl-lazy"', 'data-src');
            $objShowFile->ShowImage('../../../../', $objShowFile->FileLocation("attachedimage"), $objArrayImage[1], $product->Name, 336, 'class="card-img rounded-0 owl-lazy"', 'data-src');

            $image_one_address = $objShowFile->FileLocation("attachedimage") . 'thumbnail/' . $objShowFile->NameChSize($objShowFile->FileLocation("attachedimage"), $objArrayImage[0], 336);
            $image_two_address = $objShowFile->FileLocation("attachedimage") . 'thumbnail/' . $objShowFile->NameChSize($objShowFile->FileLocation("attachedimage"), $objArrayImage[1], 336);


            $product_content = $product->ProductType . ' ' . $product->PCategory . ' ' . $product->PGroup;
            $arr_product_offer = $strOldPricingPart == 0 ? array('offer1' => '') : array('offer1' => '<div class="text-bg-danger p-1 mb-2"><small>تخفیف</small></div>');


            $arr_product_detail = array(
                'name' => $product->Name,
                'product_content' => $product_content,
                'image_one_address' => $image_one_address,
                'image_two_address' => $image_two_address,
                'str_price' => $strPricingPart,
                'str_old_price' => $strOldPricingPart,
                'product_page_url' => $product_page_url,
                'size' => $product->Size
            );


            $arr_product_note = array(
                'note1' => '<h6 class="m-0">تحویل از راه دور</h6>'
            );
            $arr_product_detials = array_merge(
                $arr_product_detail,
                $arr_product_offer,
                $arr_product_note
            );
            $products_diteils[] = $arr_product_detials;
        }


        echo json_encode($products_diteils);
    } else {
        echo false;
    }

} else {
    echo false;
}