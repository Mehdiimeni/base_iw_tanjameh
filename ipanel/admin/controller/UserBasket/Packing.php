<?php
//Packing.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$Enabled = true;


if (isset($_POST['SubmitM'])) {


    $objTimeTools = new TimeTools();
    $objAclTools = new ACLTools();

    $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
    
    
    $now_modify = date("Y-m-d H:i:s");
    $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

    $arrAllImageSelected = $_POST['ImageSelected'];
    $PackWeight = $_POST['PackWeight'];
    $Description = $_POST['Description'];
    $BasketIdKey = $_POST['BasketIdKey'];

    $PackingNu = $objAclTools->IdKey();

    foreach ($arrAllImageSelected as $Keys => $Values) {

        foreach ($Values as $key => $value) {

            $UCondition = " ProductId = '$value' and BasketIdKey = '$Keys' and (ChkState = 'bought' or ChkState = 'preparation')  ";

            $USet = "";
            $USet .= " ChkState = 'packing' ,";
            $USet .= " PackingNu = '$PackingNu' ,";
            $USet .= " PackWeight = '$PackWeight' , ";
            $USet .= " Description = '$Description' , ";
            $USet .= " modify_ip = '$modify_ip' ,";
            
            
            $USet .= " last_modify = '$now_modify' ";

            $objORM->DataUpdate($UCondition, $USet, TableIWAUserMainCart);

        }
    }


    $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
    JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('act')));
    exit();


}
if (@$_GET['IdKey'] != null) {
    $IdKey = $_GET['IdKey'];


    $strListHead = (new ListTools())->TableHead(array(''), FA_LC['null_value']);


    $ToolsIcons[] = $arrToolsIcon["view"];
    $ToolsIcons[] = $arrToolsIcon["edit"];
    $ToolsIcons[] = $arrToolsIcon["active"];


//image
    $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
    $objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
    $objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

    $objStorageTools = new StorageTools($objFileToolsInit->KeyValueFileReader()['MainName']);
    $objStorageTools->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');


    $intRowCounter = 0;
    $intIdMaker = 0;
    $strListBody = '';
    $intProductIn = 0;
    $SCondition = "  UserId = '$IdKey' and Enabled != 0  and (ChkState = 'bought' or ChkState = 'preparation') group by BasketIdKey ORDER BY id DESC";
    foreach ($objORM->FetchAll($SCondition, '*', TableIWAUserMainCart) as $ListItem) {

        // user
        $SCondition = "id = $ListItem->iw_user_id";
        $objUserData = @$objORM->Fetch($SCondition, '*', TableIWUser);

        //address
        $SCondition = "id = '$ListItem->UserAddressId'";
        $objAddressData = @$objORM->Fetch($SCondition, '*', TableIWUserAddress);

        $strListBody .= '<table style="margin:10px; padding:10px; width: 100%; " border="1">';
        $strListBody .= '<tbody>';
        $strListBody .= '<tr><td style="margin:5px; padding:5px; text-align: center; ">' . FA_LC["name"] . '</td>';
        $strListBody .= '<td style="margin:5px; padding:5px; text-align: center; ">' . $objUserData->Name . '</td></tr>';
        $strListBody .= '<tr><td style="margin:5px; padding:5px; text-align: center;">' . FA_LC["email"] . '</td>';
        $strListBody .= '<td style="margin:5px; padding:5px; text-align: center;">' . $objUserData->Email . '</td></tr>';
        $strListBody .= '<tr><td style="margin:5px; padding:5px; text-align: center;">' . FA_LC["basket"] . '</td>';
        $strListBody .= '<td style="margin:5px; padding:5px; text-align: center;">' . $ListItem->id . '</td></tr>';
        $strListBody .= '<tr><td style="margin:5px; padding:5px; text-align: center;">' . FA_LC["tel"] . '</td>';
        $strListBody .= '<td style="margin:5px; padding:5px; text-align: center;">' . $objAddressData->OtherTel . '</td></tr>';
        $strListBody .= '<tr><td style="margin:5px; padding:5px; text-align: center;">' . FA_LC["address"] . '</td>';
        $strListBody .= '<td style="margin:5px; padding:5px; text-align: center;">' . $objAddressData->Address . '</td></tr>';
        $strListBody .= '<tr><td style="margin:5px; padding:5px; text-align: center;">' . FA_LC["post_code"] . '</td>';
        $strListBody .= '<td style="margin:5px; padding:5px; text-align: center;">' . $objAddressData->PostCode . '</td></tr>';
        $strListBody .= '<tr><td style="margin:5px; padding:5px; text-align: center;"><a target="_blank" class="btn btn-success" href="?ln=&part=Users&page=Invocie&PaymentIdKey='.$ListItem->PaymentIdKey.'&BasketIdKey=' . $ListItem->BasketIdKey . '">' . FA_LC["invocie"] . '</a></td>';
        $strListBody .= '<td style="margin:5px; padding:5px; text-align: right;">'. (new ListTools())->ButtonReflector($arrToolsIcon["reverse_basket"], $objGlobalVar->en2Base64($ListItem->id . '::==::' . TableIWAUserMainCart, 0)) . '</td></tr>';

        $strListBody .= '<tr>';
        $strListBody .= '<table style="margin:10px; padding:10px; width: 100%; " border="1">';
        $strListBody .= '<tbody>';
        $strListBody .= '<tr>';

        $SCondition = "  BasketIdKey = '$ListItem->BasketIdKey' and Enabled != 0  and (ChkState = 'bought' or ChkState = 'preparation')  ";
        foreach ($objORM->FetchAll($SCondition, '*', TableIWAUserMainCart) as $ListItem2) {
            $SCondition = "Enabled = $Enabled AND  ProductId = '$ListItem2->ProductId' ";
            $APIProducts = $objORM->Fetch($SCondition, '*', TableIWAPIProducts);


            $SCondition = "id = '$APIProducts->iw_product_weight_id'";
            $WeightValue = @$objORM->Fetch($SCondition, 'Weight', TableIWWebWeightPrice)->Weight;

            $objArrayImage = explode("==::==", $APIProducts->Content);
            $strListBody .= '<td style="margin:5px; padding:5px; text-align: center;"><a class="pimagemodalclass" href="#PImageModal" data-toggle="modal" data-img-url="' . $objShowFile->FileLocation("attachedimage") . @$objArrayImage[0] . '"> <i class="fa fa-search-plus fa-lg"></i> </a><input type="checkbox" class="flat child "  value="' . $ListItem2->ProductId . '"   name="ImageSelected[' . $ListItem->BasketIdKey . '][]"><label for="' . $intIdMaker . '" >' . $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[0], $APIProducts->ProductId, 120, 'id="myImg" class="cursor_pointer"') . '</label></td>';
            $strListBody .= '<td style="margin:5px; padding:5px; text-align: center;"><b>' . FA_LC["total_count"] . ' : ' . $ListItem2->Count . '</b>';
            $strListBody .= '<br><b>' . FA_LC["weight"] . ' : ' . $WeightValue . ' KG </b>';
            $strListBody .= '<br><b>' . FA_LC["price"] . ' : ' . $APIProducts->MainPrice . '  </b>';
            $strListBody .= '<br><b>' . FA_LC["size"] . ' : ' . $ListItem2->Size . '  </b>';
            $strListBody .= '<br><b>' . FA_LC["product_code"] . ' : ' . $ListItem2->ProductCode . '  </b>';
            $strListBody .= '<br><b>' . $APIProducts->Name . '  </b></td>';
            $intProductIn++;
            $strListBody .= '<input name="AllProduct[]" value="' . $ListItem2->id . '" type="hidden">';
        }
        $strListBody .= '</tr>';
        $strListBody .= '</tbody>';
        $strListBody .= '</table>';
        $strListBody .= '</tr>';
        $strListBody .= '</tbody>';
        $strListBody .= '</table>';


// list
        if (@$_GET['list'] != '') {
            $_SESSION['strListSet'] = $_GET['list'];
        } else {
            $_SESSION['strListSet'] = 'normal';
        }

    }

}

