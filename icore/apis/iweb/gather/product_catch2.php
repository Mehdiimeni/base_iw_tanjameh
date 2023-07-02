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

// check api count
$strExpireDate = date("m-Y");
if (($objORM->Fetch("CompanyIdKey = '4a897b83' and ExpireDate = '$strExpireDate' ", "Count", TableIWAPIAllConnect)->Count) > 39000)
    exit();

$ModifyTime = $objTimeTools->jdate("H:i:s");
$ModifyDate = $objTimeTools->jdate("Y/m/d");
$ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;

$ModifyDateNow = $objAclTools->Nu2EN($objTimeTools->jdate("Y/m/d"));


$arrIdAllProduct = array();
// API Count and Connect
$objAsos = new AsosConnections();

$TimePriod = $objTimeTools->DateDayStepper("-1");

$TimePriod = $objAclTools->JsonDecodeArray(json_encode($TimePriod));
$TimePriod = $TimePriod["date"];

//$SCondition = " CreateCad = 0 OR ModifyStrTime < '$TimePriod' ";
$SCondition = "ModifyStrTime < '$TimePriod' order by rand() limit 1";
foreach ($objORM->FetchAll($SCondition, 'CatId,IdKey,Name,LocalName,NewMenuId,GroupIdKey,WeightIdKey,Enabled,IdRow,ModifyStrTime', TableIWNewMenu4) as $ListItem) {

    if (!($objORM->Fetch("IdKey = '$ListItem->NewMenuId' ", "Enabled", TableIWNewMenu)->Enabled))
    {

        $UCondition = " IdKey = '$ListItem->IdKey' ";
        $USet = " CreateCad = 1 ,";
        $USet .= " ModifyTime = '$ModifyTime' ,";
        $USet .= " ModifyDate = '$ModifyDate' ,";
        $USet .= " ModifyStrTime = '$ModifyStrTime' ";

        $objORM->DataUpdate($UCondition, $USet, TableIWNewMenu4);

        continue;
    }


    $objPGroup = $objORM->Fetch("IdKey = '$ListItem->GroupIdKey' ", 'Name,GroupIdKey', TableIWNewMenu3);
    $PGroup = $objPGroup->Name;
    $objPCategory = $objORM->Fetch("IdKey = '$objPGroup->GroupIdKey' ", 'Name,GroupIdKey', TableIWNewMenu2);
    $PCategory = $objPCategory->Name;
    $PGender = $objORM->Fetch("IdKey = '$objPCategory->GroupIdKey' ", 'Name', TableIWNewMenu)->Name;

    $PGroup2 = $ListItem->Name;
    $Attribute = $ListItem->Name;


    $CatId = $ListItem->CatId;

    $WeightIdKey = $ListItem->WeightIdKey;
    $ProductContentAt = $objAsos->ProductsListAt($CatId, "", 15);

    $strExpireDate = date("m-Y");
    $UCondition = " CompanyIdKey = '4a897b83' and ExpireDate = '$strExpireDate' ";
    $USet = " Count = Count + 1 ";
    $objORM->DataUpdate($UCondition, $USet, TableIWAPIAllConnect);

    $ListProductsContentAt = $objAclTools->JsonDecodeArray($objAclTools->deBase64($ProductContentAt));

    foreach ($ListProductsContentAt['products'] as $product) {


        $MainPrice = $product['price']['current']['value'];
        $ProductName = $objAclTools->strReplace($product['name'], "'");
        $ProductName = $objAclTools->strReplace($ProductName, '"');

        if (in_array(strtolower($ProductName), ARR_PRODUCT_FILTER))
            continue;

        $ProductId = $product['id'];

        $product['price']['previous']['value'] != null ? $ApiLastPrice = $product['price']['previous']['value'] : $ApiLastPrice = 0;
        $ProductCode = $product['productCode'];

        $ApiContent = $objAclTools->enBase64($objAclTools->JsonEncode($product), 0);
        $SCondition = "   ProductId = '$ProductId'   ";

        if (!$objORM->DataExist($SCondition, TableIWAPIProducts)) {

            // API Count and Connect
            // check api count
            $strExpireDate = date("m-Y");
            $obj_api_connect = $objORM->Fetch("CompanyIdKey = '4a897b83' and ExpireDate = '$strExpireDate' ", "*", TableIWAPIAllConnect);

            if ($obj_api_connect != false and (int) ($obj_api_connect->Count) < 50000) {


                $whitelist = array(
                    '127.0.0.1',
                    '::1'
                );

                if (!in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {


                    $objAsos = new AsosConnections();
                    $ApiContent = $objAsos->ProductsDetail($ProductId);

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
                    ProductId = '$ProductId' ,
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
                                    WeightIdKey = '$WeightIdKey',
                                            CompanyIdKey = '4a897b83' ,
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
                    $iw_api_product_id = $objORM->LastId();


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

                        $str_change = "   product_id= $product_id,
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
                                            iw_api_products_id = $iw_api_product_id ";

                        $variant_condition = "product_id= $product_id";

                        if (!$objORM->DataExist($variant_condition, TableIWApiProductVariants, 'id')) {

                            $objORM->DataAdd($str_change, TableIWApiProductVariants);
                        } else {

                            $objORM->DataUpdate($variant_condition, $str_change, TableIWApiProductVariants);
                        }

                    }




                }


            }



        }



        if ($objORM->DataExist("Content IS NULL and ProductId = '$ProductId'", TableIWAPIProducts)) {


            $arrApiProductDetail = $objAclTools->JsonDecodeArray($objAclTools->deBase64($objAsos->ProductsDetail($ProductId)));
            $strExpireDate = date("m-Y");
            $UCondition = " CompanyIdKey = '4a897b83' and ExpireDate = '$strExpireDate' ";
            $USet = " Count = Count + 1 ";
            $objORM->DataUpdate($UCondition, $USet, TableIWAPIAllConnect);

            if (isset($arrApiProductDetail['media']['images']) and count($arrApiProductDetail['media']['images']) > 0 and $arrApiProductDetail['isInStock']) {

                $arrImage = array();

                $ProductType = $arrApiProductDetail['productType']['name'] ?? null;

                if (in_array(strtolower($ProductType), ARR_PRODUCT_FILTER))
                    continue;

                foreach ($arrApiProductDetail['media']['images'] as $ProductImage) {

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


                    $FileNewName = $objShowFile->FileSetNewName('jpg');
                    $arrImage[] = $FileNewName;


                    $fp = fopen('../../../../irepository/img/attachedimage/' . $FileNewName, "w");
                    fwrite($fp, $content);
                    fclose($fp);


                }

                $strImages = implode("==::==", $arrImage);
                $UCondition = " ProductId = '$ProductId' ";
                $USet = "Content = '$strImages'";

                $objORM->DataUpdate($UCondition, $USet, TableIWAPIProducts);


            }
        }
    }


}

echo json_encode('--product catch 2--');