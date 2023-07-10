<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../../iassets/include/DBLoader.php";


if (isset($_POST['id_row'])) {

    $id_row = $_POST['id_row'];
    $condition = "id = $id_row ";
    $currencies_conversion_id = trim($_POST['currencies_conversion_id']);

    if ($objORM->DataExist($condition, ViewIWProductRand)) {

        $obj_row_product = @$objORM->Fetch($condition, "*", ViewIWProductRand);

        $objFileToolsInit = new FileTools("../../../idefine/conf/init.iw");
        $objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);

        $objShowFile->SetRootStoryFile('../../../irepository/img/');

        $objArrayImage = explode("==::==", $obj_row_product->Content);
        $objArrayImage = array_combine(range(1, count($objArrayImage)), $objArrayImage);

        $intImageCounter = 1;
        foreach ($objArrayImage as $image) {
            if (@strpos($obj_row_product->ImageSet, (string) $intImageCounter) === false) {

                unset($objArrayImage[$intImageCounter]);
            }
            $intImageCounter++;
        }
        $objArrayImage = array_values($objArrayImage);


        $argument = "$obj_row_product->id,$currencies_conversion_id";
        $CarentCurrencyPrice = (float) @$objORM->FetchFunc($argument, FuncIWFuncPricing)[0]->Result;
        $PreviousCurrencyPrice = (float) @$objORM->FetchFunc($argument, FuncIWFuncLastPricing)[0]->Result;

        $name_currency = $objORM->Fetch(
            "id =" . $objORM->Fetch(
                "id = $currencies_conversion_id",
                "iw_currencies_id2",
                TableIWACurrenciesConversion
            )->iw_currencies_id2,
            "Name",
            TableIWACurrencies
        )->Name;

        $strPricingPart = '';

        $boolChange = 0;

        if ($CarentCurrencyPrice != $PreviousCurrencyPrice and $PreviousCurrencyPrice != 0)
            $boolChange = 1;



        if ($CarentCurrencyPrice != null) {
            $CarentCurrencyPrice = $objGlobalVar->NumberFormat($CarentCurrencyPrice, 0, ".", ",");
            $CarentCurrencyPrice = $objGlobalVar->Nu2FA($CarentCurrencyPrice);
            $strPricingPart .= '<h6 class="fw-semibold">' . $CarentCurrencyPrice . ' ' . $name_currency . '</h6>';
        }
        $strOldPricingPart = 0;

        if ($PreviousCurrencyPrice != null and $boolChange) {
            $PreviousCurrencyPrice = $objGlobalVar->NumberFormat($PreviousCurrencyPrice, 0, ".", ",");
            $PreviousCurrencyPrice = $objGlobalVar->Nu2FA($PreviousCurrencyPrice);
            $strOldPricingPart = '<h6><del>' . $PreviousCurrencyPrice . ' ' . $name_currency . '</del></h6>';
        }


        $str_image = $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), $objArrayImage[0], $obj_row_product->Name, 336, 'class="card-img rounded-0 owl-lazy"', 'data-src');

        $arr_product_detail = array(
            'name' => $obj_row_product->Name,
            'product_type' => $obj_row_product->ProductType,
            'brand_name' => $obj_row_product->BrandName,
            'image' => $str_image,
            'str_price' => $strPricingPart

        );
        $arr_product_offer = array(
            'offer1' => '<div class="text-bg-light p-1 mb-2"><small>جدید</small></div>'
        );
        $arr_product_note = array(
            'note1' => '<h6 class="m-0">تحویل از راه دور</h6>'
        );
        $arr_product_detials = array_merge(
            $arr_product_detail,
            $arr_product_offer,
            $arr_product_note
        );
        echo json_encode($arr_product_detials);
    } else {
        echo false;
    }

} else {
    echo false;
}