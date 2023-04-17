<?php
//ProductSetter.php

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

$arrIdAllProduct = array();
// API Count and Connect
$objAsos = new AsosConnections();

foreach ($objORM->FetchLimit("Enabled = $Enabled and Content IS NOT NULL and CatId IS NOT NULL  and SetProductChange = 0   ", '*', 'IdRow DESC', '0,1', TableIWAPIAllProducts) as $ListProducts) {

    $AllProductsContent = $objAclTools->JsonDecodeArray($objAclTools->deBase64($ListProducts->Content));

    $MainCategory = '';


    if (@$AllProductsContent['products'] != null) {


        $PGender = $ListProducts->PGender;
        $PCategory = $ListProducts->PCategory;
        $PGroup = $ListProducts->PGroup;
        $PGroup2 = $ListProducts->PGroup2;
        $CatId = $ListProducts->CatId;
        $TypeSet = $ListProducts->TypeSet;

        if (count($arrIdAllProduct) == 0) {
            foreach ($AllProductsContent['products'] as $product) {
                $arrIdAllProduct[] = $product['id'];
            }
        }

        foreach ($AllProductsContent['products'] as $product) {
            $MainPrice = $product['price']['current']['value'];

            $ProductName = $objAclTools->strReplace($product['name'], "'");
            $ProductName = $objAclTools->strReplace($ProductName, '"');
            $ProductId = $product['id'];
            $ProductUrl = $product['url'];
            $BrandName = $product['brandName'];
            $BrandName = str_replace('"', "", $BrandName);
            $BrandName = str_replace("'", "", $BrandName);

            $product['price']['previous']['value'] != null ? $ApiLastPrice = $product['price']['previous']['value'] : $ApiLastPrice = 0;

            $ApiContent = $objAclTools->enBase64($objAclTools->JsonEncode($product), 0);


            $SCondition = "   ProductId = '$ProductId'   ";

            if ($objORM->DataExist($SCondition, TableIWAPIProducts)) {


                $USet = "";
                $USet .= " Name = '$ProductName' ,";
                $USet .= " PGender = '$PGender' ,";
                $USet .= " ApiContent = '$ApiContent' ,";
                $USet .= " PCategory = '$PCategory' ,";
                $USet .= " PGroup = '$PGroup' ,";
                $USet .= " PGroup2 = '$PGroup2' ,";
                $USet .= " Url = '$ProductUrl' ,";
                $USet .= " CatId = concat_ws(',',CatId,'" . $CatId . "') ,";
                $USet .= " MainPrice = $MainPrice ,";
                $USet .= " LastPrice = $ApiLastPrice, ";
                $USet .= " ModifyDateP = '$ModifyDate' ,";
                $USet .= " BrandName = '$BrandName' ,";
                $USet .= " TypeSet = '$TypeSet' ,";
                $USet .= " ModifyIP = '$ModifyIP' ,";
                $USet .= " ModifyTime = '$ModifyTime' ,";
                $USet .= " ModifyDate = '$ModifyDate' ,";
                $USet .= " ModifyStrTime = '$ModifyStrTime' ";

                $objORM->DataUpdate("   ProductId = '$ProductId'   ", $USet, TableIWAPIProducts);

            } else {


                $IdKey = $objAclTools->IdKey();


                $InSet = "";
                $InSet .= " IdKey = '$IdKey' ,";
                $InSet .= " Enabled = '$Enabled' ,";
                $InSet .= " ProductId = '$ProductId' ,";
                $InSet .= " Name = '$ProductName' ,";
                $InSet .= " ApiContent = '$ApiContent' ,";
                $InSet .= " PGender = '$PGender' ,";
                $InSet .= " PCategory = '$PCategory' ,";
                $InSet .= " PGroup = '$PGroup' ,";
                $InSet .= " PGroup2 = '$PGroup2' ,";
                $InSet .= " Url = '$ProductUrl' ,";
                $InSet .= " CatId = '$CatId' ,";
                $InSet .= " MainPrice = $MainPrice ,";
                $InSet .= " LastPrice = $ApiLastPrice, ";
                $InSet .= " ModifyDateP = '$ModifyDate' ,";
                $InSet .= " CompanyIdKey = '4a897b83' ,";
                $InSet .= " BrandName = '$BrandName' ,";
                $InSet .= " TypeSet = '$TypeSet' ,";
                $InSet .= " ModifyIP = '$ModifyIP' ,";
                $InSet .= " ModifyTime = '$ModifyTime' ,";
                $InSet .= " ModifyDate = '$ModifyDate' ,";
                $InSet .= " ModifyStrTime = '$ModifyStrTime', ";
                $InSet .= " ModifyId = ' ' ";
                $objORM->DataAdd($InSet, TableIWAPIProducts);

            }

            if ($objORM->DataExist("Content IS NULL and ProductId = '$ProductId'", TableIWAPIProducts)) {


                $arrApiProductDetail = $objAclTools->JsonDecodeArray($objAclTools->deBase64($objAsos->ProductsDetail($ProductId)));
                $strExpireDate = date("m-Y");
                $UCondition = " CompanyIdKey = '4a897b83' and ExpireDate = '$strExpireDate' ";
                $USet = " Count = Count + 1 ";
                $objORM->DataUpdate($UCondition, $USet, TableIWAPIAllConnect);

                if (isset($arrApiProductDetail['media']['images']) and count($arrApiProductDetail['media']['images']) > 0 and $arrApiProductDetail['isInStock']) {

                    $arrImage = array();

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


                        $fp = fopen(IW_REPOSITORY_FROM_PANEL . 'img/attachedimage/' . $FileNewName, "w");
                        fwrite($fp, $content);
                        fclose($fp);


                    }

                    $ProductType = $arrApiProductDetail['productType']['name'] ?? null;


                    //Color
                    $arrColor = array();
                    $arrColorDis = array();
                    $strColor = '';
                    if (is_array(@$arrApiProductDetail['variants'])) {
                        foreach ($arrApiProductDetail['variants'] as $Color) {
                            if (!$Color['isInStock'])
                                $arrColorDis[] = $Color['colour'];

                            $arrColor[] = $Color['colour'];
                        }
                        $arrColor = array_unique($arrColor);
                        $strColor = implode(",", $arrColor);
                    }

//Size
                    $arrSize = array();
                    $arrSizeDis = array();
                    $strSize = '';
                    $strSizeDis = '';
                    if (is_array(@$arrApiProductDetail['variants'])) {
                        foreach ($arrApiProductDetail['variants'] as $Size) {
                            if (!$Size['isInStock'])
                                $arrSizeDis[] = $Size['brandSize'];

                            $arrSize[] = $Size['brandSize'];

                        }
                        $arrSize = array_unique($arrSize);
                        $arrSizeDis = array_unique($arrSizeDis);
                        $strSize = implode(",", $arrSize);
                        $strSizeDis = implode(",", $arrSizeDis);
                    }

                    $parts = parse_url($objAclTools->FindUrlInString($arrApiProductDetail['description']));
                    $parts['path'] = str_replace('"', "", $parts['path']);
                    $parts['path'] = str_replace("'", "", $parts['path']);
                    $arrPath = array_filter(explode("/", $parts['path']));
                    unset($arrPath[count($arrPath)]);


                    $arrApiProductDetail['price']['previous']['value'] != null ? $ApiLastPrice = $arrApiProductDetail['price']['previous']['value'] : $ApiLastPrice = 0;

                    $BrandName = str_replace('"', "", $BrandName);
                    $BrandName = str_replace("'", "", $BrandName);



                    $strImages = implode("==::==", $arrImage);
                    $UCondition = " ProductId = '$ProductId' ";
                    $USet = "Content = '$strImages',";
                    $USet .= " ApiContent = '$ApiContent' ,";
                    $USet .= " PCategory = '$PCategory' ,";
                    $USet .= " PGroup = '$PGroup' ,";
                    $USet .= " PGroup2 = '$PGroup2' ,";
                    $USet .= " Url = '$ProductUrl' ,";
                    $USet .= " LastPrice = $ApiLastPrice, ";
                    $USet .= " ProductType = '$ProductType', ";
                    $USet .= " Color = '$strColor', ";
                    $USet .= " Size = '$strSize', ";
                    $USet .= " SizeDis = '$strSizeDis', ";
                    $USet .= " CatId = concat_ws(',',CatId,'" . $CatId . "') ,";
                    $USet .= " BrandName = '$BrandName' ,";
                    $USet .= " TypeSet = '$TypeSet' ,";
                    $USet .= " ModifyIP = '$ModifyIP' ,";
                    $USet .= " ModifyTime = '$ModifyTime' ,";
                    $USet .= " ModifyDate = '$ModifyDate' ,";
                    $USet .= " RootDateCheck = '$ModifyStrTime' ,";
                    $USet .= " ModifyStrTime = '$ModifyStrTime'";
                    $objORM->DataUpdate($UCondition, $USet, TableIWAPIProducts);


                }
            }

        }

    }


}


$UCondition = " IdKey = '$ListProducts->IdKey' ";
$USet = " SetProductChange = 1 ";
$objORM->DataUpdate($UCondition, $USet, TableIWAPIAllProducts);

