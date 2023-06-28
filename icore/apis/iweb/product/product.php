<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../../iassets/include/DBLoader.php";


if (isset($_POST['item'])) {

    $item = $_POST['item'];

    $condition = "IdRow = '$item' and Enabled = 1 AND Content IS NOT NULL AND AdminOk = 1   ";

    if ($objORM->DataExist($condition, TableIWAPIProducts)) {

        // view count
        $USet = "PView = PView + 1";
        $objORM->DataUpdate($condition, $USet, TableIWAPIProducts);


        $obj_product = @$objORM->Fetch($condition, "*", TableIWAPIProducts);


        // API Count and Connect
        // check api count
        $strExpireDate = date("m-Y");
        if (($objORM->Fetch("CompanyIdKey = '4a897b83' and ExpireDate = '$strExpireDate' ", "Count", TableIWAPIAllConnect)->Count) < 50000) {


            $whitelist = array(
                '127.0.0.1',
                '::1'
            );

            if (!in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {


                $objAsos = new AsosConnections();
                $ApiContent = $objAsos->ProductsDetail($obj_product->ProductId);
                $strExpireDate = date("m-Y");
                $UCondition = " CompanyIdKey = '4a897b83' and ExpireDate = '$strExpireDate' ";
                $USet = " Count = Count + 1 ";
                $objORM->DataUpdate($UCondition, $USet, TableIWAPIAllConnect);
                $objProductData = json_decode(base64_decode($ApiContent),true);
                
                $product_type = $objProductData['productType']['name'];


            } else {

                $product_type = $obj_product->ProductType;

            }


        } else {

            $product_type = $obj_product->ProductType;
        }


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


        $strPricingPart = '';
        $SArgument = "'$obj_product->IdRow','c72cc40d','fea9f1bf'";
        $CarentCurrencyPrice = @$objORM->FetchFunc($SArgument, FuncIWFuncPricing);
        $PreviousCurrencyPrice = @$objORM->FetchFunc($SArgument, FuncIWFuncLastPricing);
        $CarentCurrencyPrice = $CarentCurrencyPrice[0]->Result;
        $PreviousCurrencyPrice = $PreviousCurrencyPrice[0]->Result;

        //persent
        if ($PreviousCurrencyPrice > $CarentCurrencyPrice) {
            $discount_persent = floor(($PreviousCurrencyPrice / $CarentCurrencyPrice) * 100);
            $discount_persent = $objGlobalVar->Nu2FA($discount_persent);
        } else {
            $discount_persent = 0;
        }

        $boolChange = 0;

        if ($CarentCurrencyPrice != $PreviousCurrencyPrice and $PreviousCurrencyPrice != 0)
            $boolChange = 1;

        if ($CarentCurrencyPrice != null) {
            $CarentCurrencyPrice = $objGlobalVar->NumberFormat($CarentCurrencyPrice, 0, ".", ",");
            $CarentCurrencyPrice = $objGlobalVar->Nu2FA($CarentCurrencyPrice);
            $strPricingPart = '<h4 class="d-inline-block me-2 text-danger prices"><span class="product-price">' . $CarentCurrencyPrice . '</span> تومان</h4>';
        }

        $strOldPricingPart = 0;

        if ($PreviousCurrencyPrice != null and $boolChange) {
            $PreviousCurrencyPrice = $objGlobalVar->NumberFormat($PreviousCurrencyPrice, 0, ".", ",");
            $PreviousCurrencyPrice = $objGlobalVar->Nu2FA($PreviousCurrencyPrice);
            $strOldPricingPart = '<del class="d-block">' . $PreviousCurrencyPrice . ' تومان</del>';
        }


        $obj_product_page_url = "?gender=" . $obj_product->PGender . "&category=" . $obj_product->PCategory . "&group=" . $obj_product->PGroup . "&item=" . $obj_product->IdRow;

        $images_address = array();
        foreach ($objArrayImage as $image) {
            $images_address[] = $objShowFile->FileLocation("attachedimage") . $image;
        }

        $obj_product_content = $obj_product->ProductType . ' ' . $obj_product->PCategory . ' ' . $obj_product->PGroup;
        $arr_product_offer = $strOldPricingPart == 0 ? array('offer1' => '') : array('offer1' => '<div class="text-bg-danger p-1 mb-2"><small>تخفیف</small></div>');
        $count_score = 0;

        //all size 
        $all_size = explode(',', $obj_product->Size);
        $all_disabled_size =  explode(',', $obj_product->SizeDis);

        $arr_product_detail = array(
            'name' => $obj_product->Name,
            'product_content' => $obj_product_content,
            'images_address' => $images_address,
            'str_price' => $strPricingPart,
            'str_old_price' => $strOldPricingPart,
            'product_page_url' => $obj_product_page_url,
            'all_size' => $all_size,
            'all_disabled_size' => $all_disabled_size,
            'discount_persent' => $discount_persent,
            'score' => $obj_product->PScore,
            'count_score' => $count_score,
            'product_type' => $product_type,
            'brand_name' => $obj_product->BrandName,
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