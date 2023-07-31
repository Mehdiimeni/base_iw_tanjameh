<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../../iassets/include/DBLoader.php";

$objFileToolsInit = new FileTools("../../../idefine/conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile('../../../../irepository/img/');


// filter setter
require_once "../../../idefine/queryset/ProductFilter.php";


$Enabled = true;

$objAclTools = new ACLTools();
$objTimeTools = new TimeTools();

$iw_company_id = $_POST['iw_company_id'];


// check api count
$expire_date = date("m-Y");
if (($objORM->Fetch("iw_company_id = $iw_company_id and expire_date = '$expire_date' ", "all_count", TableIWAPIAllConnect)->all_count) > 39000)
    exit();



$now_modify = date("Y-m-d H:i:s");
$yesterday = date('Y-m-d H:i:s', strtotime("-1 day"));


$arrIdAllProduct = array();
// API Count and Connect
$objAsos = new AsosConnections();

//$SCondition = " CreateCad = 0 OR ModifyStrTime < '$TimePriod' ";
$SCondition = "last_modify < '$yesterday' and Enabled = 1 order by rand() limit 1 ";



foreach ($objORM->FetchAll($SCondition, 'CatId,Name,LocalName,iw_new_menu_2_id,iw_product_weight_id,Enabled,id', TableIWNewMenu3) as $ListItem) {



    if (!($objORM->Fetch("id = $ListItem->iw_new_menu_2_id ", "Enabled", TableIWNewMenu2)->Enabled)) {

        $UCondition = " id = $ListItem->id ";
        $USet = " CreateCad = 1 ,";
        $USet .= " last_modify = '$now_modify' ";
        $objORM->DataUpdate($UCondition, $USet, TableIWNewMenu3);

        continue;
    }


    $PGroup = $ListItem->Name;
    $objPCategory = $objORM->Fetch("id = $ListItem->iw_new_menu_2_id ", 'Name,iw_new_menu_id', TableIWNewMenu2);
    $PCategory = $objPCategory->Name;
    $PGender = $objORM->Fetch("id = '$objPCategory->iw_new_menu_id' ", 'Name', TableIWNewMenu)->Name;

    $PGroup2 = '';
    $CatId = $ListItem->CatId;




    $iw_product_weight_id = $ListItem->iw_product_weight_id;
    $ProductContentAt = $objAsos->ProductsListAt($CatId, "", 15);

    $ListProductsContentAt = $objAclTools->JsonDecodeArray($ProductContentAt);



    $expire_date = date("m-Y");
    $UCondition = " iw_company_id = $iw_company_id and expire_date = '$expire_date' ";
    $USet = " all_count = all_count + 1 ";
    $objORM->DataUpdate($UCondition, $USet, TableIWAPIAllConnect);



    foreach ($ListProductsContentAt['products'] as $product) {


        $MainPrice = $product['price']['current']['value'];
        $ProductName = $objAclTools->strReplace($product['name'], "'");
        $ProductName = $objAclTools->strReplace($ProductName, '"');



        if (in_array(strtolower($ProductName), ARR_PRODUCT_FILTER))
            continue;

        $ProductId = $product['id'];

        $product['price']['previous']['value'] != null ? $ApiLastPrice = $product['price']['previous']['value'] : $ApiLastPrice = 0;
        $ProductCode = $product['productCode'];

        $SCondition = "ProductId = $ProductId";

        if (!$objORM->DataExist($SCondition, TableIWAPIProducts, 'id')) {

            // API Count and Connect
            // check api count
            $expire_date = date("m-Y");
            $api_connect_count = $objORM->Fetch("iw_company_id = $iw_company_id and expire_date = '$expire_date' ", "all_count", TableIWAPIAllConnect)->all_count;



            if ($api_connect_count != false and (int) ($api_connect_count) < 50000) {


                $whitelist = array(
                    '127.0.0.1',
                    '::1'
                );

                if (!in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {


                    $objAsos = new AsosConnections();
                    $objProductData = json_decode($objAsos->ProductsDetail($ProductId), true);

                    $expire_date = date("m-Y");
                    $UCondition = " iw_company_id = $iw_company_id and expire_date = '$expire_date' ";
                    $USet = " all_count = all_count + 1 ";
                    $objORM->DataUpdate($UCondition, $USet, TableIWAPIAllConnect);


                    if (in_array(strtolower($objProductData['productType']['name']), ARR_PRODUCT_FILTER)) {
                        continue;
                    }


                    $isInStock = $objProductData['isInStock'] == true ? 1 : 0;
                    if (!$isInStock)
                        continue;


                    $Name = $objProductData['name'];
                    $Name = str_replace("'", "\'", $Name);
                    $Name = str_replace('"', '\"', $Name);
                    $gender = $objProductData['gender'];
                    $ProductCode = $objProductData['productCode'];
                    $isNoSize = $objProductData['isNoSize'] == true ? 1 : 0;
                    $isOneSize = $objProductData['isOneSize'] == true ? 1 : 0;

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
                         description = '$brand_description' ";

                    $brand_condition = "brand_id = $brandId";
                    if (!$objORM->DataExist($brand_condition, TableIWApiBrands, 'id')) {

                        $objORM->DataAdd($str_change, TableIWApiBrands);
                        $iw_api_brands_id = $objORM->LastId();
                    } else {

                        $objORM->DataUpdate($brand_condition, $str_change, TableIWApiBrands);
                        $iw_api_brands_id = $objORM->Fetch($brand_condition, "id", TableIWApiBrands)->id;
                    }



                    $product_type_id = $objProductData['productType']['id'];
                    $product_type_name = $objProductData['productType']['name'];
                    $product_type_name = str_replace("'", "\'", $product_type_name);
                    $product_type_name = str_replace('"', '\"', $product_type_name);


                    $str_change = " product_type_id = $product_type_id ,
                         name = '$product_type_name' ";

                    $type_condition = "product_type_id = $product_type_id";
                    if (!$objORM->DataExist($type_condition, TableIWApiProductType, 'id')) {

                        $objORM->DataAdd($str_change, TableIWApiProductType);
                        $iw_api_product_type_id = $objORM->LastId();
                    } else {

                        $objORM->DataUpdate($type_condition, $str_change, TableIWApiProductType);
                        $iw_api_product_type_id = $objORM->Fetch($type_condition, "id", TableIWApiProductType)->id;
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

                    

                    $str_change = "
                                ProductId = $ProductId ,
                                ProductCode='$ProductCode',
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
                                iw_product_weight_id = $iw_product_weight_id,
                                iw_company_id = $iw_company_id ,
                                Enabled = 1 ,
                                url_gender = '$PGender' ,
                                url_category = '$PCategory' ,
                                url_group = '$PGroup' ,
                                url_group2 = '$PGroup2' ,
                                info='$info',
                                isDeadProduct='$isDeadProduct',
                                rating='$rating',
                                CatIds='$CatIds',
                                iw_api_brands_id=$iw_api_brands_id,
                                iw_api_product_type_id=$iw_api_product_type_id ";

                    $objORM->DataAdd($str_change, TableIWAPIProducts);
                    $iw_api_product_id = $objORM->Fetch(
                        "ProductId = $ProductId",
                        "id",
                        TableIWAPIProducts
                    )->id;


                    $str_change = " PView = PView + 1 , iw_api_products_id = $iw_api_product_id ";
                    $type_condition = "iw_api_products_id = $iw_api_product_id";
                    if (!$objORM->DataExist($type_condition, TableIWApiProductStatus, 'iw_api_products_id')) {

                        $objORM->DataAdd($str_change, TableIWApiProductStatus);
                    } else {

                        $objORM->DataUpdate($type_condition, $str_change, TableIWApiProductStatus);
                    }


                    foreach ($objProductData['variants'] as $variant) {

                        $price_current = $variant['price']['current']['value'];
                        $price_previous = $variant['price']['previous']['value'];


                        $product_id = $variant['id'];
                        $name = $variant['name'];
                        $name = str_replace("'", "\'", $name);
                        $name = str_replace('"', '\"', $name);
                        $sizeId = $variant['sizeId'];
                        $brandSize = $variant['brandSize'];
                        $sizeDescription = $variant['sizeDescription'];
                        $displaySizeText = $variant['displaySizeText'];
                        $sizeOrder = $variant['sizeOrder'];
                        $isInStock = $variant['isInStock'] == true ? 1 : 0;
                        $isAvailable = $variant['isAvailable'] == true ? 1 : 0;
                        $colour = $variant['colour'];
                        $isProp65Risk = $variant['isProp65Risk'] == true ? 1 : 0;

                        $str_change = " 
                                        product_id= $product_id,
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
                                        iw_company_id=$iw_company_id,
                                        iw_api_products_id = $iw_api_product_id ";

                        $variant_condition = "product_id= $product_id";

                        if (!$objORM->DataExist($variant_condition, TableIWApiProductVariants, 'id')) {

                            $objORM->DataAdd($str_change, TableIWApiProductVariants);
                        } else {

                            $objORM->DataUpdate($variant_condition, $str_change, TableIWApiProductVariants);
                        }

                    }



                    if ($objORM->DataExist("Content IS NULL and ProductId = $ProductId", TableIWAPIProducts, 'id')) {


                        if (!empty($objProductData['media']['images']) and count($objProductData['media']['images']) > 0 and $objProductData['isInStock']) {

                            $arrImage = array();

                            foreach ($objProductData['media']['images'] as $ProductImage) {


                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, 'https://' . $ProductImage['url'] . '?wid=1400');
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                                curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_WHATEVER);
                                curl_setopt($ch, CURLOPT_ENCODING, "");
                                curl_setopt($ch, CURLOPT_MAXREDIRS, 40);
                                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                                curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

                                $content = curl_exec($ch);
                                curl_close($ch);


                                $FileNewName = $objShowFile->FileSetNewName('webp');
                                $arrImage[] = $FileNewName;


                                $fp = fopen('../../../../irepository/img/attachedimage/' . $FileNewName, "x");
                                fwrite($fp, $content);
                                fclose($fp);


                            }

                            $strImages = implode("==::==", $arrImage);
                            $UCondition = " ProductId = $ProductId ";
                            $USet = "Content = '$strImages'";

                            $objORM->DataUpdate($UCondition, $USet, TableIWAPIProducts);


                        } else {

                            $UCondition = " ProductId = $ProductId ";
                            $USet = "Enabled = 0 ";

                            $objORM->DataUpdate($UCondition, $USet, TableIWAPIProducts);


                        }
                    }





                }


            }



        }






    }


}

echo json_encode('--product catch--');