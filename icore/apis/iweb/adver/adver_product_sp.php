<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../../iassets/include/DBLoader.php";
$objFileToolsDBInfo = db_info();
$objORM = db_orm($objFileToolsDBInfo);


if (!empty($_POST['page_name_system'])) {

    $website_page_name = trim($_POST['page_name_system']);
    $currencies_conversion_id = trim($_POST['currencies_conversion_id']);

    $condition = " Enabled = 1 and name = '$website_page_name' ";

    if ($objORM->DataExist($condition, TableIWWebSitePages, 'id')) {

        $iw_website_pages_id = @$objORM->Fetch($condition, "id", TableIWWebSitePages)->id;



        if (!empty($_POST['adver_number'])) {
            $adver_number = 'Adver' . $_POST['adver_number'];
            $condition = "  iw_website_pages_id = $iw_website_pages_id and Enabled = 1 and name = '$adver_number'  ";

            if ($objORM->DataExist($condition, TableIWWebSitePagesPart, 'id')) {
                $iw_website_pages_part_id = @$objORM->Fetch($condition, "id", TableIWWebSitePagesPart)->id;

                $condition = "iw_website_pages_part_id = $iw_website_pages_part_id and Enabled = 1";

                if ($objORM->DataExist($condition, TableIWWebSiteBannerAdver, 'id')) {
                    $condition_statement = @$objORM->Fetch($condition, "condition_statement", TableIWWebSiteBannerAdver)->condition_statement;
                    if ($objORM->DataExist($condition_statement, ViewIWProductRand,'id')) {

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
                                $strPricingPart .= '<h6 class="fw-semibold">' . $CarentCurrencyPrice .' '. $name_currency .'</h6>';
                            }
                            $strOldPricingPart = 0;

                            if ($PreviousCurrencyPrice != null and $boolChange) {
                                $PreviousCurrencyPrice = $objGlobalVar->NumberFormat($PreviousCurrencyPrice, 0, ".", ",");
                                $PreviousCurrencyPrice = $objGlobalVar->Nu2FA($PreviousCurrencyPrice);
                                $strOldPricingPart  = '<h6><del>' . $PreviousCurrencyPrice .' '. $name_currency .'</del></h6>';
                            }



                            $product_page_url = "?gender=" . urlencode($product->url_gender) . "&category=" . urlencode($product->url_category) . "&group=" . urlencode($product->url_group) . "&item=" . $product->id;
                            $str_image = $objShowFile->ShowImage('../../../../', $objShowFile->FileLocation("attachedimage"), $objArrayImage[0], $product->Name, 336, 'class="card-img rounded-0 owl-lazy"', 'data-src');
                            $str_image = str_replace('../../../../', '', $str_image);

                            $arr_product_offer = $strOldPricingPart == 0 ? array('offer1' => '') : array('offer1' => '<div class="text-bg-danger p-1 mb-2 position-absolute bottom-0 end-0"><small>تخفیف</small></div>');


                            $brand_name = @$objORM->Fetch("id = '$product->brands_id' ", 'name', TableIWApiBrands)->name;
                            $product_type = @$objORM->Fetch("id = '$product->product_type_id' ", 'name', TableIWApiProductType)->name;




                            $arr_product_detail = array(
                                'name' => $product->Name,
                                'id' => $product->id,
                                'product_type' => $product_type,
                                'brand_name' => $brand_name,
                                'product_type_id' => $product->product_type_id,
                                'brand_id' => $product->brands_id,
                                'image' => $str_image,
                                'str_price' => $strPricingPart,
                                'str_old_price' => $strOldPricingPart,
                                'product_page_url' => $product_page_url,
                                'company_id' => $product->company_id
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
            } else {
                echo false;
            }
        }


    } else {
        echo false;
    }
} else {
    echo false;
}