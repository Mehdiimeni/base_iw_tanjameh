<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../../iassets/include/DBLoader.php";
$objFileToolsDBInfo = db_info();
$objORM = db_orm($objFileToolsDBInfo);

if (!empty($_POST['post_id'])) {

    $post_id = $_POST['post_id'];
    $currencies_conversion_id = $_POST['currencies_conversion_id'];

    if ($objORM->DataExist(" id = $post_id  and enabled = 1 and stat = 1", TableIWUserLookPost)) {

        $obj_look_post = $objORM->Fetch(" id = $post_id ", "*", TableIWUserLookPost);
        $obj_look_page = $objORM->Fetch(" user_id = $obj_look_post->user_id ", "*", TableIWUserLookPage);

        $objFileToolsInit = new FileTools("../../../idefine/conf/init.iw");
        $objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
        $objShowFile->SetRootStoryFile('./irepository/img/');


        $obj_user_post = $objORM->Fetch(
            "id = $post_id",
            "*",
            TableIWUserLookPost
        );
        $arr_user_post = array();

        if (!empty($obj_look_post->itemm1)) {
            $product_id1 = $obj_look_post->itemm1;
            $product_type1 = 'main';
        } else {
            $product_id1 = $obj_look_post->iteml1;
            $product_type1 = 'look';
        }

        if (!empty($obj_look_post->itemm2)) {

            $product_id2 = $obj_look_post->itemm2;
            $product_type2 = 'main';

        } else {
            $product_id2 = $obj_look_post->iteml2;
            $product_type2 = 'look';
        }
        if (!empty($obj_look_post->itemm3)) {
            $product_id3 = $obj_look_post->itemm3;
            $product_type3 = 'main';
        } else {
            $product_id3 = $obj_look_post->iteml3;
            $product_type3 = 'look';
        }
        if (!empty($obj_look_post->itemm4)) {
            $product_id4 = $obj_look_post->itemm4;
            $product_type4 = 'main';
        } else {
            $product_id4 = $obj_look_post->iteml4;
            $product_type4 = 'look';
        }


        $obj_product1 = @$objORM->Fetch("id = $product_id1 ", "id,Name,Content,ImageSet,MainPrice,LastPrice,CatIds,Color, iw_company_id,iw_api_product_type_id,iw_api_brands_id", TableIWAPIProducts);
        $obj_product2 = @$objORM->Fetch("id = $product_id2 ", "id,Name,Content,ImageSet,MainPrice,LastPrice,CatIds,Color, iw_company_id,iw_api_product_type_id,iw_api_brands_id", TableIWAPIProducts);
        $obj_product3 = @$objORM->Fetch("id = $product_id3 ", "id,Name,Content,ImageSet,MainPrice,LastPrice,CatIds,Color, iw_company_id,iw_api_product_type_id,iw_api_brands_id", TableIWAPIProducts);
        $obj_product4 = @$objORM->Fetch("id = $product_id4 ", "id,Name,Content,ImageSet,MainPrice,LastPrice,CatIds,Color, iw_company_id,iw_api_product_type_id,iw_api_brands_id", TableIWAPIProducts);


        $objArrayImage1 = explode("==::==", $obj_product1->Content);
        $objArrayImage1 = array_combine(range(1, count($objArrayImage1)), $objArrayImage1);

        $intImageCounter1 = 1;
        foreach ($objArrayImage1 as $image1) {
            if (@strpos($obj_product1->ImageSet, (string) $intImageCounter1) === false) {

                unset($objArrayImage1[$intImageCounter1]);
            }
            $intImageCounter1++;
        }
        $objArrayImage1 = array_values($objArrayImage1);


        $argument1 = "$obj_product1->id,$currencies_conversion_id";
        $CarentCurrencyPrice1 = (float) @$objORM->FetchFunc($argument1, FuncIWFuncPricing)[0]->Result;
        $PreviousCurrencyPrice1 = (float) @$objORM->FetchFunc($argument1, FuncIWFuncLastPricing)[0]->Result;

        $name_currency = $objORM->Fetch(
            "id =" . $objORM->Fetch(
                "id = $currencies_conversion_id",
                "iw_currencies_id1",
                TableIWACurrenciesConversion
            )->iw_currencies_id1,
            "Name",
            TableIWACurrencies
        )->Name;

        //persent
        if ($PreviousCurrencyPrice1 > $CarentCurrencyPrice1) {
            $discount_persent1 = floor((($PreviousCurrencyPrice1 - $CarentCurrencyPrice1) / $PreviousCurrencyPrice1) * 100);
            $discount_persent1 = $objGlobalVar->Nu2FA($discount_persent1);
        } else {
            $discount_persent1 = 0;
        }

        $boolChange1 = 0;

        if ($CarentCurrencyPrice1 != $PreviousCurrencyPrice1 and $PreviousCurrencyPrice1 != 0)
            $boolChange1 = 1;



        if ($CarentCurrencyPrice1 != null) {
            $CarentCurrencyPrice1 = $objGlobalVar->NumberFormat($CarentCurrencyPrice1, 0, ".", ",");
            $CarentCurrencyPrice1 = $objGlobalVar->Nu2FA($CarentCurrencyPrice1);
        }

        $strOldPricingPart1 = 0;

        if ($PreviousCurrencyPrice1 != null and $boolChange1) {
            $PreviousCurrencyPrice1 = $objGlobalVar->NumberFormat($PreviousCurrencyPrice1, 0, ".", ",");
            $PreviousCurrencyPrice1 = $objGlobalVar->Nu2FA($PreviousCurrencyPrice1);
        }


        $obj_brand_name1 = @$objORM->Fetch("id = $obj_product1->iw_api_brands_id ", 'name,id', TableIWApiBrands);
        $obj_product_type1 = @$objORM->Fetch("id = $obj_product1->iw_api_product_type_id ", 'name,id', TableIWApiProductType);

        $image_product_address1 = $objShowFile->image_address_edit('../../../../', $objShowFile->FileLocation("attachedimage"), $objArrayImage1[0], $obj_product1->Name, 336, '');
        $image_product_address1 = str_replace('../../../../', '', $image_product_address1);


        $objArrayImage2 = explode("==::==", $obj_product2->Content);
        $objArrayImage2 = array_combine(range(1, count($objArrayImage2)), $objArrayImage2);

        $intImageCounter2 = 1;
        foreach ($objArrayImage2 as $image2) {
            if (@strpos($obj_product2->ImageSet, (string) $intImageCounter2) === false) {

                unset($objArrayImage2[$intImageCounter2]);
            }
            $intImageCounter2++;
        }
        $objArrayImage2 = array_values($objArrayImage2);


        $argument2 = "$obj_product2->id,$currencies_conversion_id";
        $CarentCurrencyPrice2 = (float) @$objORM->FetchFunc($argument2, FuncIWFuncPricing)[0]->Result;
        $PreviousCurrencyPrice2 = (float) @$objORM->FetchFunc($argument2, FuncIWFuncLastPricing)[0]->Result;

        $name_currency = $objORM->Fetch(
            "id =" . $objORM->Fetch(
                "id = $currencies_conversion_id",
                "iw_currencies_id1",
                TableIWACurrenciesConversion
            )->iw_currencies_id1,
            "Name",
            TableIWACurrencies
        )->Name;

        //persent
        if ($PreviousCurrencyPrice2 > $CarentCurrencyPrice2) {
            $discount_persent2 = floor((($PreviousCurrencyPrice2 - $CarentCurrencyPrice2) / $PreviousCurrencyPrice2) * 100);
            $discount_persent2 = $objGlobalVar->Nu2FA($discount_persent2);
        } else {
            $discount_persent2 = 0;
        }

        $boolChange2 = 0;

        if ($CarentCurrencyPrice2 != $PreviousCurrencyPrice2 and $PreviousCurrencyPrice2 != 0)
            $boolChange2 = 1;



        if ($CarentCurrencyPrice2 != null) {
            $CarentCurrencyPrice2 = $objGlobalVar->NumberFormat($CarentCurrencyPrice2, 0, ".", ",");
            $CarentCurrencyPrice2 = $objGlobalVar->Nu2FA($CarentCurrencyPrice2);
        }

        $strOldPricingPart2 = 0;

        if ($PreviousCurrencyPrice2 != null and $boolChange2) {
            $PreviousCurrencyPrice2 = $objGlobalVar->NumberFormat($PreviousCurrencyPrice2, 0, ".", ",");
            $PreviousCurrencyPrice2 = $objGlobalVar->Nu2FA($PreviousCurrencyPrice2);
        }


        $obj_brand_name2 = @$objORM->Fetch("id = $obj_product2->iw_api_brands_id ", 'name,id', TableIWApiBrands);
        $obj_product_type2 = @$objORM->Fetch("id = $obj_product2->iw_api_product_type_id ", 'name,id', TableIWApiProductType);

        $image_product_address2 = $objShowFile->image_address_edit('../../../../', $objShowFile->FileLocation("attachedimage"), $objArrayImage2[0], $obj_product2->Name, 336, '');
        $image_product_address2 = str_replace('../../../../', '', $image_product_address2);


        $objArrayImage3 = explode("==::==", $obj_product3->Content);
        $objArrayImage3 = array_combine(range(1, count($objArrayImage3)), $objArrayImage3);

        $intImageCounter3 = 1;
        foreach ($objArrayImage3 as $image3) {
            if (@strpos($obj_product3->ImageSet, (string) $intImageCounter3) === false) {

                unset($objArrayImage3[$intImageCounter3]);
            }
            $intImageCounter3++;
        }
        $objArrayImage3 = array_values($objArrayImage3);


        $argument3 = "$obj_product3->id,$currencies_conversion_id";
        $CarentCurrencyPrice3 = (float) @$objORM->FetchFunc($argument3, FuncIWFuncPricing)[0]->Result;
        $PreviousCurrencyPrice3 = (float) @$objORM->FetchFunc($argument3, FuncIWFuncLastPricing)[0]->Result;

        $name_currency = $objORM->Fetch(
            "id =" . $objORM->Fetch(
                "id = $currencies_conversion_id",
                "iw_currencies_id1",
                TableIWACurrenciesConversion
            )->iw_currencies_id1,
            "Name",
            TableIWACurrencies
        )->Name;

        //persent
        if ($PreviousCurrencyPrice3 > $CarentCurrencyPrice3) {
            $discount_persent3 = floor((($PreviousCurrencyPrice3 - $CarentCurrencyPrice3) / $PreviousCurrencyPrice3) * 100);
            $discount_persent3 = $objGlobalVar->Nu2FA($discount_persent3);
        } else {
            $discount_persent3 = 0;
        }

        $boolChange3 = 0;

        if ($CarentCurrencyPrice3 != $PreviousCurrencyPrice3 and $PreviousCurrencyPrice3 != 0)
            $boolChange3 = 1;



        if ($CarentCurrencyPrice3 != null) {
            $CarentCurrencyPrice3 = $objGlobalVar->NumberFormat($CarentCurrencyPrice3, 0, ".", ",");
            $CarentCurrencyPrice3 = $objGlobalVar->Nu2FA($CarentCurrencyPrice3);
        }

        $strOldPricingPart3 = 0;

        if ($PreviousCurrencyPrice3 != null and $boolChange3) {
            $PreviousCurrencyPrice3 = $objGlobalVar->NumberFormat($PreviousCurrencyPrice3, 0, ".", ",");
            $PreviousCurrencyPrice3 = $objGlobalVar->Nu2FA($PreviousCurrencyPrice3);
        }


        $obj_brand_name3 = @$objORM->Fetch("id = $obj_product3->iw_api_brands_id ", 'name,id', TableIWApiBrands);
        $obj_product_type3 = @$objORM->Fetch("id = $obj_product3->iw_api_product_type_id ", 'name,id', TableIWApiProductType);

        $image_product_address3 = $objShowFile->image_address_edit('../../../../', $objShowFile->FileLocation("attachedimage"), $objArrayImage3[0], $obj_product3->Name, 336, '');
        $image_product_address3 = str_replace('../../../../', '', $image_product_address3);

        $objArrayImage4 = explode("==::==", $obj_product4->Content);
        $objArrayImage4 = array_combine(range(1, count($objArrayImage4)), $objArrayImage4);

        $intImageCounter4 = 1;
        foreach ($objArrayImage4 as $image4) {
            if (@strpos($obj_product4->ImageSet, (string) $intImageCounter4) === false) {

                unset($objArrayImage4[$intImageCounter4]);
            }
            $intImageCounter4++;
        }
        $objArrayImage4 = array_values($objArrayImage4);


        $argument4 = "$obj_product4->id,$currencies_conversion_id";
        $CarentCurrencyPrice4 = (float) @$objORM->FetchFunc($argument4, FuncIWFuncPricing)[0]->Result;
        $PreviousCurrencyPrice4 = (float) @$objORM->FetchFunc($argument4, FuncIWFuncLastPricing)[0]->Result;

        $name_currency = $objORM->Fetch(
            "id =" . $objORM->Fetch(
                "id = $currencies_conversion_id",
                "iw_currencies_id1",
                TableIWACurrenciesConversion
            )->iw_currencies_id1,
            "Name",
            TableIWACurrencies
        )->Name;

        //persent
        if ($PreviousCurrencyPrice4 > $CarentCurrencyPrice4) {
            $discount_persent4 = floor((($PreviousCurrencyPrice4 - $CarentCurrencyPrice4) / $PreviousCurrencyPrice4) * 100);
            $discount_persent4 = $objGlobalVar->Nu2FA($discount_persent4);
        } else {
            $discount_persent4 = 0;
        }

        $boolChange4 = 0;

        if ($CarentCurrencyPrice4 != $PreviousCurrencyPrice4 and $PreviousCurrencyPrice4 != 0)
            $boolChange4 = 1;



        if ($CarentCurrencyPrice4 != null) {
            $CarentCurrencyPrice4 = $objGlobalVar->NumberFormat($CarentCurrencyPrice4, 0, ".", ",");
            $CarentCurrencyPrice4 = $objGlobalVar->Nu2FA($CarentCurrencyPrice4);
        }

        $strOldPricingPart4 = 0;

        if ($PreviousCurrencyPrice4 != null and $boolChange4) {
            $PreviousCurrencyPrice4 = $objGlobalVar->NumberFormat($PreviousCurrencyPrice4, 0, ".", ",");
            $PreviousCurrencyPrice4 = $objGlobalVar->Nu2FA($PreviousCurrencyPrice4);
        }


        $obj_brand_name4 = @$objORM->Fetch("id = $obj_product4->iw_api_brands_id ", 'name,id', TableIWApiBrands);
        $obj_product_type4 = @$objORM->Fetch("id = $obj_product4->iw_api_product_type_id ", 'name,id', TableIWApiProductType);

        $image_product_address4 = $objShowFile->image_address_edit('../../../../', $objShowFile->FileLocation("attachedimage"), $objArrayImage4[0], $obj_product4->Name, 336, '');
        $image_product_address4 = str_replace('../../../../', '', $image_product_address4);



        $image_b1_address = $objShowFile->image_address_edit('../../../../', $objShowFile->FileLocation("look_page_post"), $obj_user_post->image1, $obj_look_page->look_page_name, 0, '');
        $image_b1_address = str_replace('../../../../', '', $image_b1_address);
        $image_b2_address = $objShowFile->image_address_edit('../../../../', $objShowFile->FileLocation("look_page_post"), $obj_user_post->image2, $obj_look_page->look_page_name, 0, '');
        $image_b2_address = str_replace('../../../../', '', $image_b2_address);
        $image_b3_address = $objShowFile->image_address_edit('../../../../', $objShowFile->FileLocation("look_page_post"), $obj_user_post->image3, $obj_look_page->look_page_name, 0, '');
        $image_b3_address = str_replace('../../../../', '', $image_b3_address);
        $image_b4_address = $objShowFile->image_address_edit('../../../../', $objShowFile->FileLocation("look_page_post"), $obj_user_post->image4, $obj_look_page->look_page_name, 0, '');
        $image_b4_address = str_replace('../../../../', '', $image_b4_address);

        $look_page_profile = $objShowFile->image_address_edit('../../../../', $objShowFile->FileLocation("look_page"), $obj_look_page->look_page_profile, $obj_look_page->look_page_name, 120, '', '');
        $look_page_profile = str_replace('../../../../', '', $look_page_profile);


        $arr_user_post = array(

            'image_b1_address' => $image_b1_address,
            'image_b2_address' => $image_b2_address,
            'image_b3_address' => $image_b3_address,
            'image_b4_address' => $image_b4_address,
            'name_currency' => $name_currency,
            'price1' => $CarentCurrencyPrice1,
            'last_price1' => $PreviousCurrencyPrice1,
            'discount_persent1' => $discount_persent1,
            'image_product_address1' => $image_product_address1,
            'brand_name1' => $obj_brand_name1->name,
            'brand_id1' => $obj_brand_name1->id,
            'product_type_name1' => $obj_product_type1->name,
            'product_type_id1' => $obj_product_type1->id,
            'product_name1' => $obj_product1->Name,
            'product_color1' => $obj_product1->Color,
            'price2' => $CarentCurrencyPrice2,
            'last_price2' => $PreviousCurrencyPrice2,
            'discount_persent2' => $discount_persent2,
            'image_product_address2' => $image_product_address2,
            'brand_name2' => $obj_brand_name2->name,
            'brand_id2' => $obj_brand_name2->id,
            'product_type_name2' => $obj_product_type2->name,
            'product_type_id2' => $obj_product_type2->id,
            'product_name2' => $obj_product2->Name,
            'product_color2' => $obj_product2->Color,
            'price3' => $CarentCurrencyPrice3,
            'last_price3' => $PreviousCurrencyPrice3,
            'discount_persent3' => $discount_persent3,
            'image_product_address3' => $image_product_address3,
            'brand_name3' => $obj_brand_name3->name,
            'brand_id3' => $obj_brand_name3->id,
            'product_type_name3' => $obj_product_type3->name,
            'product_type_id3' => $obj_product_type3->id,
            'product_name3' => $obj_product3->Name,
            'product_color3' => $obj_product3->Color,
            'price4' => $CarentCurrencyPrice4,
            'last_price4' => $PreviousCurrencyPrice4,
            'discount_persent4' => $discount_persent4,
            'image_product_address4' => $image_product_address4,
            'brand_name4' => $obj_brand_name4->name,
            'brand_id4' => $obj_brand_name4->id,
            'product_type_name4' => $obj_product_type4->name,
            'product_type_id4' => $obj_product_type4->id,
            'product_name4' => $obj_product4->Name,
            'product_color4' => $obj_product4->Color,
            'product_id1' => $obj_product1->id,
            'product_type1' => $product_type1,
            'product_id2' => $obj_product2->id,
            'product_type2' => $product_type2,
            'product_id3' => $obj_product3->id,
            'product_type3' => $product_type3,
            'product_id4' => $obj_product4->id,
            'product_type4' => $product_type4,
            'look_page_profile' => $look_page_profile,
            'user_id' => $obj_look_page->user_id,
            'look_page_name' => $obj_look_page->look_page_name,
            'post_id' => $obj_user_post->id,
        );


        echo json_encode($arr_user_post);

    } else {
        echo false;
    }

} else {
    echo false;
}