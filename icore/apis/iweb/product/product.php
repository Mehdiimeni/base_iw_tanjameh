<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../../iassets/include/DBLoader.php";


if (isset($_POST['item'])) {

    $item = $_POST['item'];

    $condition = "id = '$item' and Enabled = 1 AND Content IS NOT NULL AND AdminOk = 1   ";

    if ($objORM->DataExist($condition, TableIWAPIProducts,'id')) {

        // view count
        $USet = "PView = PView + 1";
        $objORM->DataUpdate("iw_api_products_id = '$item'", $USet, TableIWApiProductStatus);


        $obj_product = @$objORM->Fetch($condition, "
        id,
        ProductId,
        ProductCode,
        Name,
        url_gender,
        url_category,
        url_group,
        Content,
        ImageSet,
        MainPrice,
        LastPrice,
        iw_product_weight_id,
        CatIds,
        NoWeightValue,
        Color,
        gender,
        isInStock,
        info,
        last_modify,
        iw_api_product_type_id,
        iw_api_brands_id", TableIWAPIProducts);

        $last_modify = strtotime($obj_product->last_modify);
        $curtime = time();
        $now_modify = date("Y-m-d H:i:s");

        // API Count and Connect
        // check api count
        $strExpireDate = date("m-Y");
        $obj_api_connect = $objORM->Fetch("CompanyIdKey = '4a897b83' and ExpireDate = '$strExpireDate' ", "*", TableIWAPIAllConnect);

        if ($obj_api_connect != false and (int) ($obj_api_connect->Count) < 50000 and (($curtime - $last_modify) > 21600)) {


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

                $objProductData = json_decode(base64_decode($ApiContent), true);

                $Name = $objProductData['name'];
                $Name = str_replace("'", "\'", $Name);
                $Name = str_replace('"', '\"', $Name);
                $gender = $objProductData['gender'];
                $ProductCode = $objProductData['productCode'];
                $isNoSize = $objProductData['isNoSize'] == true ? 1 : 0;
                $isOneSize = $objProductData['isOneSize'] == true ? 1 : 0;
                $isInStock = $objProductData['isInStock'] == true ? 1 : 0;
                $prop65Risk = $objProductData['hasVariantsWithProp65Risk'] == true ? 1 : 0;


                $info = json_encode($objProductData['info']);
                $info = str_replace("'", "\'", $info);
                $info = str_replace('"', '\"', $info);
                $rating = json_encode($objProductData['rating']);
                $rating = str_replace("'", "\'", $rating);
                $rating = str_replace('"', '\"', $rating);
                $isDeadProduct = $objProductData['isDeadProduct'];
                $MainPrice = $objProductData['price']['current']['value'];
                $LastPrice = $objProductData['price']['previous']['value'];
                $Url = $objProductData['localisedData'][0]['pdpUrl'];
                $brandId = $objProductData['brand']['brandId'];
                $product_type_id = $objProductData['productType']['id'];



                $brandId = $objProductData['brand']['brandId'];
                $brand_name = $objProductData['brand']['name'];
                $brand_name = str_replace("'", "\'", $brand_name);
                $brand_name = str_replace('"', '\"', $brand_name);
                $brand_description = $objProductData['brand']['description'];
                $brand_description = str_replace("'", "\'", $brand_description);
                $brand_description = str_replace('"', '\"', $brand_description);

                $str_change = "  brand_id = $brandId ,
                     name = '$brand_name' ,
                     description = '$brand_description',
                     last_modify = '$now_modify' ";

                $brand_condition = "brand_id = $brandId";
                if (!$objORM->DataExist($brand_condition, TableIWApiBrands, 'id')) {

                    $objORM->DataAdd($str_change, TableIWApiBrands);
                    $iw_api_brands_id = $objORM->LastId();
                } else {

                    $objORM->DataUpdate($brand_condition, $str_change, TableIWApiBrands);
                    $iw_api_brands_id = $obj_product->iw_api_brands_id;
                }





                $product_type_id = $objProductData['productType']['id'];
                $product_type_name = $objProductData['productType']['name'];
                $product_type_name = str_replace("'", "\'", $product_type_name);
                $product_type_name = str_replace('"', '\"', $product_type_name);

                $str_change = " product_type_id = $product_type_id ,
                     name = '$product_type_name',
                     last_modify = '$now_modify' ";

                $type_condition = "product_type_id = $product_type_id";
                if (!$objORM->DataExist($type_condition, TableIWApiProductType, 'id')) {

                    $objORM->DataAdd($str_change, TableIWApiProductType);
                    $iw_api_product_type_id = $objORM->LastId();
                } else {

                    $objORM->DataUpdate($type_condition, $str_change, TableIWApiProductType);
                    $iw_api_product_type_id = $obj_product->iw_api_product_type_id;
                }



                $arr_cat_id = array();

                foreach ($objProductData['plpIds'] as $cat_id) {
                    $arr_cat_id[] = $cat_id['id'];
                }

                $CatIds = implode(',', $arr_cat_id);


                if (is_array(@$objProductData['variants'])) {
                    foreach ($objProductData['variants'] as $Color) {
                        $arrColor[] = $Color['colour'];
                    }
                    $arrColor = array_unique($arrColor);
                    $Color = strtolower($arrColor[0]);
                }


                $product_condition = "id = $obj_product->id";
                $str_change = " ProductCode='$ProductCode',
                                Name='$Name',
                                Url='$Url',
                                MainPrice=$MainPrice,
                                LastPrice=$LastPrice,
                                gender='$gender',
                                Color='$Color',
                                isNoSize='$isNoSize',
                                isOneSize='$isOneSize',
                                isInStock='$isInStock',
                                prop65Risk='$prop65Risk',
                                info='$info',
                                isDeadProduct='$isDeadProduct',
                                rating='$rating',
                                CatIds='$CatIds',
                                last_modify = '$now_modify',
                                iw_api_brands_id=$iw_api_brands_id,
                                iw_api_product_type_id=$iw_api_product_type_id ";

                $objORM->DataUpdate($product_condition, $str_change, TableIWAPIProducts);


                foreach ($objProductData['variants'] as $variant) {

                    $price_current = $variant['price']['current']['value'];
                    $price_previous = $variant['price']['previous']['value'];


                    $product_id = $variant['id'];
                    $name = $variant['name'];
                    $sizeId = $variant['sizeId'];
                    $brandSize = $variant['brandSize'];
                    $sizeDescription = $variant['sizeDescription'];
                    $displaySizeText = $variant['displaySizeText'];
                    $sizeOrder = $variant['sizeOrder'];
                    $isInStock = $variant['isInStock'] == true ? 1 : 0;
                    $isAvailable = $variant['isAvailable'] == true ? 1 : 0;
                    $colour = $variant['colour'];
                    $isProp65Risk = $variant['isProp65Risk'] == true ? 1 : 0;

                    $str_change = "product_id= $product_id,
                                   name='$name',
                                   sizeId=$sizeId,
                                   brandSize='$brandSize',
                                   sizeDescription='$sizeDescription',
                                   displaySizeText='$displaySizeText',
                                   sizeOrder= $sizeOrder,
                                   isInStock=$isInStock,
                                   isAvailable=$isAvailable,
                                   colour='$colour',
                                   price_current= $price_current,
                                   price_previous= $price_previous,
                                   isProp65Risk=$isProp65Risk,
                                   last_modify = '$now_modify',
                                   iw_api_products_id = $obj_product->id ";

                    $variant_condition = "product_id= $product_id";

                    if (!$objORM->DataExist($variant_condition, TableIWApiProductVariants, 'id')) {

                        $objORM->DataAdd($str_change, TableIWApiProductVariants);

                    } else {

                        $objORM->DataUpdate($variant_condition, $str_change, TableIWApiProductVariants);
                    }

                }

            }


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
        $SArgument = "'$obj_product->id','c72cc40d','fea9f1bf'";
        $CarentCurrencyPrice = @$objORM->FetchFunc($SArgument, FuncIWFuncPricing);
        $PreviousCurrencyPrice = @$objORM->FetchFunc($SArgument, FuncIWFuncLastPricing);
        $CarentCurrencyPrice = $CarentCurrencyPrice[0]->Result;
        $PreviousCurrencyPrice = $PreviousCurrencyPrice[0]->Result;

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
                $strPricingPart = '<h4 class="d-inline-block me-2 text-danger prices"><span class="product-price">' . $CarentCurrencyPrice . '</span> تومان</h4>';
            }
        } else {

            if ($CarentCurrencyPrice != null) {
                $CarentCurrencyPrice = $objGlobalVar->NumberFormat($CarentCurrencyPrice, 0, ".", ",");
                $CarentCurrencyPrice = $objGlobalVar->Nu2FA($CarentCurrencyPrice);
                $strPricingPart = '<h4 class="d-inline-block me-2  prices"><span class="product-price">' . $CarentCurrencyPrice . '</span> تومان</h4>';
            }

        }

        $strOldPricingPart = 0;

        if ($PreviousCurrencyPrice != null and $boolChange) {
            $PreviousCurrencyPrice = $objGlobalVar->NumberFormat($PreviousCurrencyPrice, 0, ".", ",");
            $PreviousCurrencyPrice = $objGlobalVar->Nu2FA($PreviousCurrencyPrice);
            $strOldPricingPart = '<del class="d-block">' . $PreviousCurrencyPrice . ' تومان</del>';
        }


        // shipping price

        $strShippingPrice = '';
        $PWIdKey = $obj_product->iw_product_weight_id;

        $objShippingTools = new ShippingTools((new MySQLConnection($objFileToolsDBInfo))->getConn());



        $intTotalShipping = $objShippingTools->FindBasketWeightPrice($objShippingTools->FindItemWeight($obj_product), $obj_product->MainPrice, 'پوند', 'تومان');

        if ($intTotalShipping != 0) {
            $intTotalShipping = $objGlobalVar->NumberFormat($intTotalShipping, 0, ".", ",");
            $strShippingPrice = $objGlobalVar->Nu2FA($intTotalShipping) . ' تومان';
        }

        // wieght

        $strShippingWeight = $objShippingTools->FindItemWeight($obj_product) . ' KG ';


        $obj_product_page_url = "?gender=" . urlencode($obj_product->url_gender) . "&category=" . urlencode($obj_product->url_category) . "&group=" . urlencode($obj_product->url_group) . "&item=" . $obj_product->id;

        $images_address = array();
        foreach ($objArrayImage as $image) {
            $images_address[] = $objShowFile->FileLocation("attachedimage") . $image;
        }

        $obj_product_content = $obj_product->url_gender . ' ' . $obj_product->url_category . ' ' . $obj_product->url_group;
        $arr_product_offer = $strOldPricingPart == 0 ? array('offer1' => '') : array('offer1' => '<div class="text-bg-danger p-1 mb-2"><small>تخفیف</small></div>');
        $count_score = 0;


        $obj_brand_name = @$objORM->Fetch("id = '$obj_product->iw_api_brands_id' ", 'name,id', TableIWApiBrands);
        $obj_product_type = @$objORM->Fetch("id = '$obj_product->iw_api_product_type_id' ", 'name,id', TableIWApiProductType);

        //all size 

        $obj_product_variants_size = @$objORM->FetchAll("iw_api_products_id = '$obj_product->id' ", 'displaySizeText,brandSize,colour,isInStock', TableIWApiProductVariants);

        $arr_size = array();
        $arr_disabled_size = array();
        foreach ($obj_product_variants_size as $size) {
            if ($size->isInStock) {
                $arr_size[] = $size->displaySizeText;
            } else {
                $arr_disabled_size[] = $size->displaySizeText;
            }

        }

        $str_size = implode(',', $arr_size);
        $str_disabled_size = implode(',', $arr_disabled_size);

        $all_size = explode(',', $str_size);
        $all_disabled_size = explode(',', $str_disabled_size);

        $arr_info = json_decode($obj_product->info, 1);

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
            'product_type' => $obj_product_type->name,
            'product_type_id' => $obj_product_type->id,
            'brand_name' => $obj_brand_name->name,
            'brand_id' => $obj_brand_name->id,
            'shipping_price' => $strShippingPrice,
            'shipping_weight' => $strShippingWeight,
            'aboutMe' => $arr_info['aboutMe'],
            'sizeAndFit' => $arr_info['sizeAndFit'],
            'careInfo' => $arr_info['careInfo'],
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