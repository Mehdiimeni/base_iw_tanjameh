<?php
//RequistApi.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$Enabled = true;
$objAclTools = new ACLTools();

$objTimeTools = new TimeTools();

$modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();


$now_modify = date("Y-m-d H:i:s");

$last_modifyNow = $objAclTools->Nu2EN($objTimeTools->jdate("Y/m/d"));

switch (@$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJsonNoSet())->modify) {
    case 'add' :
        $strModifyTitle = FA_LC["add"];
        break;
    case 'edit' :
        $strModifyTitle = FA_LC["edit"];
        break;
    case 'view' :
        $strModifyTitle = FA_LC["view"];
        break;
}

//Menu Name
$strNewMenuId = '<option value="" selected></option>';
$SCondition = " Enabled = $Enabled ORDER BY id ";
foreach ($objORM->FetchAll($SCondition, 'Name,id,LocalName', TableIWNewMenu) as $ListItem) {
    $strNewMenuId .= '<option value="' . $ListItem->id . '">' . $ListItem->LocalName . '</option>';
}


// Image load
$strImageBool = '';
$strImageBool .= '<option value="true">True</option>';
$strImageBool .= '<option value="false">False</option>';


if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();

    $arrExcept = array('Attribute' => '', 'Value' => '', 'Weight' => '', 'Description' => '', 'NewMenu2Id' => '');

    if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $CatId = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->CatId);
        $Attribute = @$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Attribute);
        $AtValue = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Value);
        $ArrName = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->ArrName);
        $AtImage = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Image);
        $Weight = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Weight);

        // Menu part
        $LocalName = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->LocalName);
        $GroupIdKey = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->GroupIdKey);
        $NewMenuId = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->NewMenuId);
        $NewMenu2Id = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->NewMenu2Id);
        $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);




        // cal weight
        if ($Weight != '') {
            $SCondition = "Weight = '$Weight'";
            $iw_product_weight_id = @$objORM->Fetch($SCondition, 'IdKey', TableIWWebWeightPrice)->IdKey;
        } else {
            $iw_product_weight_id = '';
        }


        if (!$objORM->DataExist(" Name = '$ArrName' and CatId = '$CatId' ", TableIWWebSub4Menu)) {

            $Sub4IdKey = $objAclTools->IdKey();

            $InSet = "";
            $InSet .= " IdKey = '$Sub4IdKey' ,";
            $InSet .= " Enabled = $Enabled ,";
            $InSet .= " Name = '$ArrName' ,";
            $InSet .= " iw_product_weight_id = '$iw_product_weight_id' ,";
            $InSet .= " CatId = '$CatId' ,";
            $InSet .= " modify_ip = '$modify_ip' ,";
            
            
            $InSet .= " last_modify = '$now_modify', ";
            $InSet .= " ModifyId = '' ";

            $objORM->DataAdd($InSet, TableIWWebSub4Menu);
        }


        $SCondition = "Name = '$ArrName' AND LocalName = '$LocalName' AND GroupIdKey = '$GroupIdKey'    ";

        if (!$objORM->DataExist($SCondition, TableIWNewMenu3) and $NewMenu2Id == null) {

            $objTimeTools = new TimeTools();
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            
            

            

            $now_modify = date("Y-m-d H:i:s");
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));
            $InSet = "";
            
            $InSet .= " Enabled = $Enabled ,";
            $InSet .= " GroupIdKey = '$GroupIdKey' ,";
            $InSet .= " NewMenuId = '$NewMenuId' ,";
            $InSet .= " Name = '$ArrName' ,";
            $InSet .= " CatId = '$CatId' ,";
            $InSet .= " iw_product_weight_id = '$iw_product_weight_id' ,";
            $InSet .= " LocalName = '$LocalName' ,";
            $InSet .= " Description = '$Description' ,";
            $InSet .= " modify_ip = '$modify_ip' ,";
            
            
            $InSet .= " last_modify = '$now_modify' ,";
            $InSet .= " modify_id = $ModifyId ";

            $objORM->DataAdd($InSet, TableIWNewMenu3);


            //Set Category

            $PGender = $objORM->Fetch("IdKey = '$NewMenuId' ", 'Name', TableIWNewMenu)->Name;
            $PCategory = $objORM->Fetch("IdKey = '$GroupIdKey' ", 'Name', TableIWNewMenu2)->Name;
            $PGroup = $ArrName;
            $PGroup2 = '';


        }

        $SCondition = "Name = '$ArrName' AND LocalName = '$LocalName' AND GroupIdKey = '$GroupIdKey' AND NewMenuId = '$NewMenuId'    ";

        if (!$objORM->DataExist($SCondition, TableIWNewMenu4) and $NewMenu2Id != null) {


            $objTimeTools = new TimeTools();
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            
            

            

            $now_modify = date("Y-m-d H:i:s");
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));
            $InSet = "";
            
            $InSet .= " Enabled = $Enabled ,";
            $InSet .= " GroupIdKey = '$GroupIdKey' ,";
            $InSet .= " NewMenuId = '$NewMenuId' ,";
            $InSet .= " NewMenu2Id = '$NewMenu2Id' ,";
            $InSet .= " Name = '$ArrName' ,";
            $InSet .= " CatId = '$CatId' ,";
            $InSet .= " AttributeId = '$Attribute' ,";
            $InSet .= " iw_product_weight_id = '$iw_product_weight_id' ,";
            $InSet .= " LocalName = '$LocalName' ,";
            $InSet .= " Description = '$Description' ,";
            $InSet .= " modify_ip = '$modify_ip' ,";
            
            
            $InSet .= " last_modify = '$now_modify' ,";
            $InSet .= " modify_id = $ModifyId ";

            $objORM->DataAdd($InSet, TableIWNewMenu4);

            $PGender = $objORM->Fetch("IdKey = '$NewMenuId' ", 'Name', TableIWNewMenu)->Name;
            $PCategory = $objORM->Fetch("IdKey = '$GroupIdKey' ", 'Name', TableIWNewMenu2)->Name;
            $PGroup = $objORM->Fetch("IdKey = '$NewMenu2Id' ", 'Name', TableIWNewMenu3)->Name;
            $PGroup2 = $ArrName;

        }


        $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
        $objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
        $objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

        $Enabled = BoolEnum::BOOL_TRUE();

        $objAclTools = new ACLTools();
        $objTimeTools = new TimeTools();

        $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
        
        
        $now_modify = date("Y-m-d H:i:s");

        $last_modifyNow = $objAclTools->Nu2EN($objTimeTools->jdate("Y/m/d"));




        $arrIdAllProduct = array();
// API Count and Connect
        $objAsos = new AsosConnections();

        /*  foreach ($objORM->FetchLimit("Enabled = $Enabled and CatId = $CatId and Content IS NOT NULL  ", '*', 'id DESC', '0,1', TableIWAPIAllProducts) as $ListProducts) {

              $UCondition = " IdKey = '$ListProducts->IdKey' ";
              $USet = " SetProductChange = 1 ";
              $objORM->DataUpdate($UCondition, $USet, TableIWAPIAllProducts);
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
  */
        $AttributeStringQuerySet = '&attribute_' . $Attribute . '=' . $AtValue;

        $ProductContentAt = $objAsos->ProductsListAt($CatId, $AttributeStringQuerySet, 1);


        $ListProductsContentAt = $objAclTools->JsonDecodeArray($objAclTools->deBase64($ProductContentAt));

        foreach ($ListProductsContentAt['products'] as $product) {
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


            $SCondition = "   ProductId = $ProductId   ";

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
                $USet .= " last_modifyP = '$last_modify' ,";
                $USet .= " BrandName = '$BrandName' ,";
                $USet .= " TypeSet = '$TypeSet' ,";
                $USet .= " iw_product_weight_id = '$iw_product_weight_id' ,";
                $USet .= " Attribute = '$ArrName'  ,";
                $USet .= " modify_ip = '$modify_ip' ,";
                
                
                $USet .= " last_modify = '$now_modify' ";

                $objORM->DataUpdate("   ProductId = $ProductId   ", $USet, TableIWAPIProducts);

            } else {


                


                $InSet = "";
                
                $InSet .= " Enabled = $Enabled ,";
                $InSet .= " ProductId = $ProductId ,";
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
                $InSet .= " last_modifyP = '$last_modify' ,";
                $InSet .= " iw_company_id = $obj_product->iw_company_id ,";
                $InSet .= " BrandName = '$BrandName' ,";
                $InSet .= " TypeSet = '$TypeSet' ,";
                $InSet .= " iw_product_weight_id = '$iw_product_weight_id' ,";
                $InSet .= " Attribute = '$ArrName'  ,";
                $InSet .= " modify_ip = '$modify_ip' ,";
                
                
                $InSet .= " last_modify = '$now_modify', ";
                $InSet .= " ModifyId = ' ' ";
                $objORM->DataAdd($InSet, TableIWAPIProducts);

            }

            if ($AtImage) {
                if ($objORM->DataExist("Content IS NULL and ProductId = $ProductId", TableIWAPIProducts)) {


                    $arrApiProductDetail = $objAclTools->JsonDecodeArray($objAclTools->deBase64($objAsos->ProductsDetail($ProductId)));
                    $expire_date = date("m-Y");
                    $UCondition = " iw_company_id = $obj_product->iw_company_id and expire_date = '$expire_date' ";
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
                        $UCondition = " ProductId = $ProductId ";
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
                        $USet .= " modify_ip = '$modify_ip' ,";
                        
                        
                        $USet .= " RootDateCheck = '$ModifyStrTime' ,";
                        $USet .= " last_modify = '$now_modify'";
                        $objORM->DataUpdate($UCondition, $USet, TableIWAPIProducts);


                    }
                }
            }

        }

    }

    //  }


    // }
}



