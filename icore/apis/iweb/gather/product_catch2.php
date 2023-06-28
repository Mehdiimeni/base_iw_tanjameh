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
        $ProductUrl = $product['url'];
        $BrandName = $product['brandName'];
        $BrandName = str_replace('"', "", $BrandName);
        $BrandName = str_replace("'", "", $BrandName);

        $product['price']['previous']['value'] != null ? $ApiLastPrice = $product['price']['previous']['value'] : $ApiLastPrice = 0;
        $ProductCode = $product['productCode'];
        $ApiContent = $objAclTools->enBase64($objAclTools->JsonEncode($product), 0);
        $SCondition = "   ProductId = '$ProductId'   ";

        if ($objORM->DataExist($SCondition, TableIWAPIProducts)) {
            continue;

            $USet = "";
            $USet .= " Name = '$ProductName' ,";
            $USet .= " PGender = '$PGender' ,";
            $USet .= " ProductCode = '$ProductCode' ,";
            $USet .= " ApiContent = '$ApiContent' ,";
            $USet .= " PCategory = '$PCategory' ,";
            $USet .= " PGroup = '$PGroup' ,";
            $USet .= " PGroup2 = '$PGroup2' ,";
            $USet .= " Url = '$ProductUrl' ,";
            $USet .= " MainPrice = $MainPrice ,";
            $USet .= " LastPrice = $ApiLastPrice, ";
            $USet .= " ModifyDateP = '$ModifyDate' ,";
            $USet .= " BrandName = '$BrandName' ,";
            $USet .= " WeightIdKey = '$WeightIdKey' ,";
            $USet .= " Attribute = '$Attribute'  ,";
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
            $InSet .= " ProductCode = '$ProductCode' ,";
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
            $InSet .= " WeightIdKey = '$WeightIdKey' ,";
            $InSet .= " Attribute = '$Attribute'  ,";
            $InSet .= " ModifyTime = '$ModifyTime' ,";
            $InSet .= " ModifyDate = '$ModifyDate' ,";
            $InSet .= " ModifyStrTime = '$ModifyStrTime', ";
            $InSet .= " ModifyId = ' ' ";
            $objORM->DataAdd($InSet, TableIWAPIProducts);

        }

        $UCondition = " IdKey = '$ListItem->IdKey' ";
        $USet = " CreateCad = 1 ,";
        $USet .= " ModifyTime = '$ModifyTime' ,";
        $USet .= " ModifyDate = '$ModifyDate' ,";
        $USet .= " ModifyStrTime = '$ModifyStrTime' ";

        $objORM->DataUpdate($UCondition, $USet, TableIWNewMenu4);

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
                $USet = " Content = '$strImages',";
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
                $USet .= " BrandName = '$BrandName' ,";
                $USet .= " ModifyTime = '$ModifyTime' ,";
                $USet .= " ModifyDate = '$ModifyDate' ,";
                $USet .= " RootDateCheck = '$ModifyStrTime' ,";
                $USet .= " ModifyStrTime = '$ModifyStrTime'";
                $objORM->DataUpdate($UCondition, $USet, TableIWAPIProducts);

            }
        }
    }

}


echo json_encode('--product catch 2 --');