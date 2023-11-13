<?php
require_once "../global/CommonInclude.php";


if (!empty($_POST['search'])) {

    $search = str_replace('%20', ' ', $_POST['search']);
    $page_condition = $_POST['page_condition'];
    $currencies_conversion_id = trim($_POST['currencies_conversion_id']);


    $condition = " name like '%$search%' ";
    $obj_type_id = @$objORM->Fetch($condition, 'id', TableIWApiProductType)->id;
    $obj_brand_id = @$objORM->Fetch($condition, 'id', TableIWApiBrands)->id;

    if (!empty($obj_type_id)) {
        $condition = " Enabled = 1 AND Content IS NOT NULL
    AND AdminOk = 1 AND ( iw_api_product_type_id = $obj_type_id)  " . $page_condition;

    } elseif (!empty($obj_brand_id)) {

        $condition = " Enabled = 1 AND Content IS NOT NULL
    AND AdminOk = 1 AND iw_api_brands_id = $obj_brand_id " . $page_condition;


    } elseif (!empty($obj_type_id) and !empty($obj_type_id)) {

        $condition = " Enabled = 1 AND Content IS NOT NULL
    AND AdminOk = 1 AND ( iw_api_product_type_id = $obj_type_id or iw_api_brands_id = $obj_brand_id ) " . $page_condition;


    } else {

        $condition = " Enabled = 1 AND Content IS NOT NULL
        AND AdminOk = 1 and ( Name LIKE '%$search%' ) ";

        $keywords = explode(" ", $search);


        foreach ($keywords as $key => $keyword) {
            $condition .= " OR Name LIKE '%$keyword%'";

        }

    }


    if ($objORM->DataExist($condition, TableIWAPIProducts, 'id')) {
        $obj_products = @$objORM->FetchAll($condition, "id,Name,url_gender,url_category,url_group,Content,ImageSet,MainPrice,LastPrice,iw_api_product_type_id,iw_api_brands_id", TableIWAPIProducts);

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


            $argument = "$product->id,$currencies_conversion_id";
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



            $product_page_url = "?gender=" . urlencode($product->url_gender) . "&category=" . urlencode($product->url_category) . "&group=" . urlencode($product->url_group) . "&item=" . $product->id;
            $objShowFile->ShowImage('../../../../', $objShowFile->FileLocation("attachedimage"), $objArrayImage[0], $product->Name, 336, 'class="card-img rounded-0 owl-lazy"', 'data-src');
            $objShowFile->ShowImage('../../../../', $objShowFile->FileLocation("attachedimage"), $objArrayImage[1], $product->Name, 336, 'class="card-img rounded-0 owl-lazy"', 'data-src');

            $image_one_address = $objShowFile->FileLocation("attachedimage") . 'thumbnail/' . $objShowFile->NameChSize($objShowFile->FileLocation("attachedimage"), $objArrayImage[0], 336);
            $image_two_address = $objShowFile->FileLocation("attachedimage") . 'thumbnail/' . $objShowFile->NameChSize($objShowFile->FileLocation("attachedimage"), $objArrayImage[1], 336);

            $arr_product_offer = $strOldPricingPart == 0 ? array('offer1' => '') : array('offer1' => '<div class="text-bg-danger p-1 mb-2"><small>تخفیف</small></div>');

            $brand_name = @$objORM->Fetch("id = '$product->iw_api_brands_id' ", 'name', TableIWApiBrands)->name;
            $product_type = @$objORM->Fetch("id = '$product->iw_api_product_type_id' ", 'name', TableIWApiProductType)->name;

            $obj_product_variants_size = @$objORM->FetchAll("iw_api_products_id = '$product->id' ", 'brandSize', TableIWApiProductVariants);

            $arr_size = array();
            foreach ($obj_product_variants_size as $size) {
                $arr_size[] = $size->brandSize;
            }

            $str_size = implode(',', $arr_size);

            $arr_product_detail = array(
                'name' => $product->Name,
                'id' => $product->id,
                'product_type' => $product_type,
                'brand_name' => $brand_name,
                'product_type_id' => $product->iw_api_product_type_id,
                'brand_id' => $product->iw_api_brands_id,
                'image_one_address' => $image_one_address,
                'image_two_address' => $image_two_address,
                'str_price' => $strPricingPart,
                'str_old_price' => $strOldPricingPart,
                'product_page_url' => $product_page_url,
                'size' => $str_size
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