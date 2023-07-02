<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../../iassets/include/DBLoader.php";


if (isset($_POST['adver_related'])) {

    $adver_related = $_POST['adver_related'];
    $item_id = $_POST['item'];
    $condition = "IdRow = $item_id";
    $obj_product = @$objORM->Fetch($condition, "Color,url_group,MainPrice", TableIWAPIProducts);

    $color_set = $obj_product->Color;
    $url_group_set = $obj_product->url_group;
    $price_set = $obj_product->MainPrice;
    $ten_percent_price = ($price_set * 10) / 100;
    $high_price = $price_set + $ten_percent_price;
    $low_price = $price_set - $ten_percent_price;

    switch ($adver_related) {
        case 'color':
            $condition_statement = " Color = '$color_set' LIMIT 10 ";
            break;
        case 'group':
            $condition_statement = " url_group = '$url_group_set' LIMIT 10 ";
            break;
        case 'price':
            $condition_statement = " OrginalPrice BETWEEN $low_price AND $high_price  LIMIT 10 ";
            break;
    }




    if ($objORM->DataExist($condition_statement, ViewIWProductRand)) {

        $obj_products = $objORM->FetchAll($condition_statement, '*', ViewIWProductRand);

        $objFileToolsInit = new FileTools("../../../idefine/conf/init.iw");
        $objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
        $objShowFile->SetRootStoryFile('./irepository/img/');


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
            $CarentCurrencyPrice = $product->MainPrice;
            $PreviousCurrencyPrice = $product->LastPrice;

            $boolChange = 0;

            if ($CarentCurrencyPrice != $PreviousCurrencyPrice and $PreviousCurrencyPrice != 0)
                $boolChange = 1;

            if ($CarentCurrencyPrice != null) {
                $CarentCurrencyPrice = $objGlobalVar->NumberFormat($CarentCurrencyPrice, 0, ".", ",");
                $CarentCurrencyPrice = $objGlobalVar->Nu2FA($CarentCurrencyPrice);
                $strPricingPart .= '<h6 class="fw-semibold">' . $CarentCurrencyPrice . 'تومان</h6>';
            }
            $strOldPricingPart = 0;

            if ($PreviousCurrencyPrice != null and $boolChange) {
                $PreviousCurrencyPrice = $objGlobalVar->NumberFormat($PreviousCurrencyPrice, 0, ".", ",");
                $PreviousCurrencyPrice = $objGlobalVar->Nu2FA($PreviousCurrencyPrice);
                $strOldPricingPart .= '<h6><del>' . $PreviousCurrencyPrice . 'تومان</del></h6>';
            }


            $product_page_url = "?gender=" . $product->url_gender . "&category=" . $product->url_category . "&group=" . $product->url_group . "&item=" . $product->IdRow;
            $str_image = $objShowFile->ShowImage('../../../../', $objShowFile->FileLocation("attachedimage"), $objArrayImage[0], $product->Name, 336, 'class="card-img rounded-0 owl-lazy"', 'data-src');
            $str_image = str_replace('../../../../', '', $str_image);

            $arr_product_offer = $strOldPricingPart == 0 ? array('offer1' => '') : array('offer1' => '<div class="text-bg-danger p-1 mb-2 position-absolute bottom-0 end-0"><small>تخفیف</small></div>');


            $brand_name = @$objORM->Fetch("id = '$product->brands_id' ", 'name', TableIWApiBrands)->name;
            $product_type = @$objORM->Fetch("id = '$product->product_type_id' ", 'name', TableIWApiProductType)->name;




            $arr_product_detail = array(
                'name' => $product->Name,
                'product_type' => $product_type,
                'brand_name' => $brand_name,
                'product_type_id' => $product->product_type_id,
                'brand_id' => $product->brands_id,
                'image' => $str_image,
                'str_price' => $strPricingPart,
                'str_old_price' => $strOldPricingPart,
                'product_page_url' => $product_page_url
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