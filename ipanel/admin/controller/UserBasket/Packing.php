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
    $packing_weight = $_POST['packing_weight'];
    $packing_description = $_POST['packing_description'];

    $packing_number = $objORM->Fetch("1", "MAX(packing_number) as last_number", TableIWShippingProduct)->last_number + 1;

    foreach ($arrAllImageSelected as $Keys => $Values) {

        foreach ($Values as $key => $value) {

            $UCondition = " invoice_id = $value and cart_id = $Keys   ";

            $USet = " packing_number = $packing_number ,";
            $USet .= " packing_weight = $packing_weight , ";
            $USet .= " packing_description = '$packing_description'  ";
            $objORM->DataUpdate($UCondition, $USet, TableIWShippingProduct);

            $packing_status_id = $objORM->Fetch("status = 'packing'", "id", TableIWUserOrderStatus)->id;
            $objORM->DataUpdate(
                "id = $value ",
                "user_order_status_id = $packing_status_id  ",
                TableIWAUserInvoice
            );

        }
    }




    $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
    JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('act')));
    exit();


}
if (@$_GET['cart_id'] != null) {
    $cart_id = $_GET['cart_id'];


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


    $intIdMaker = 0;
    $strListBody = '';
    $intProductIn = 0;

    $all_weight_pack = 0;
    $SCondition = "  user_shopping_cart_id = $cart_id  and Enabled != 0  and ( (status = 'bought' or status = 'preparation') or packing_number is null ) group by user_shopping_cart_id ";



    if (!$objORM->DataExist($SCondition, ViewIWUserCart, "invoice_id")) {
        echo "<script>window.location.href = './?ln=&part=UserBasket&page=AllPacking';</script>";
        exit();
    }

    foreach ($objORM->FetchAll($SCondition, '*', ViewIWUserCart) as $ListItem) {


        $strListBody .= '<table style="margin:10px; padding:10px; width: 100%; " border="1">';
        $strListBody .= '<tbody>';
        $strListBody .= '<tr><td style="margin:5px; padding:5px; text-align: center; ">' . FA_LC["name"] . '</td>';
        $strListBody .= '<td style="margin:5px; padding:5px; text-align: center; ">' . $ListItem->user_address_name . ' ' . $ListItem->user_address_family . '</td></tr>';
        $strListBody .= '<tr><td style="margin:5px; padding:5px; text-align: center;">' . FA_LC["email"] . '</td>';
        $strListBody .= '<td style="margin:5px; padding:5px; text-align: center;">' . $ListItem->email . '</td></tr>';
        $strListBody .= '<tr><td style="margin:5px; padding:5px; text-align: center;">' . FA_LC["basket"] . '</td>';
        $strListBody .= '<td style="margin:5px; padding:5px; text-align: center;">' . $ListItem->user_shopping_cart_id . '</td></tr>';
        $strListBody .= '<tr><td style="margin:5px; padding:5px; text-align: center;">' . FA_LC["mobile"] . '</td>';
        $strListBody .= '<td style="margin:5px; padding:5px; text-align: center;">' . $ListItem->mobile . '</td></tr>';
        $strListBody .= '<tr><td style="margin:5px; padding:5px; text-align: center;">' . FA_LC["tel"] . '</td>';
        $strListBody .= '<td style="margin:5px; padding:5px; text-align: center;">' . $ListItem->user_address_othertel . '</td></tr>';
        $strListBody .= '<tr><td style="margin:5px; padding:5px; text-align: center;">' . FA_LC["address"] . '</td>';
        $strListBody .= '<td style="margin:5px; padding:5px; text-align: center;">' . $ListItem->address . '</td></tr>';
        $strListBody .= '<tr><td style="margin:5px; padding:5px; text-align: center;">' . FA_LC["post_code"] . '</td>';
        $strListBody .= '<td style="margin:5px; padding:5px; text-align: center;">' . $ListItem->post_code . '</td></tr>';
        $strListBody .= '<tr><td style="margin:5px; padding:5px; text-align: center;"><a target="_blank" class="btn btn-success" href="?ln=&part=Users&page=Invocie&payment_id=' . $ListItem->payment_id . '&cart_id=' . $ListItem->user_shopping_cart_id . '">' . FA_LC["invocie"] . '</a></td>';
        $strListBody .= '<td style="margin:5px; padding:5px; text-align: right;">' . (new ListTools())->ButtonReflector($arrToolsIcon["reverse_basket"], $objGlobalVar->en2Base64($ListItem->invoice_id . '::==::' . TableIWAUserInvoice, 0)) . '</td></tr>';

        $strListBody .= '<tr>';
        $strListBody .= '<table style="margin:10px; padding:10px; width: 100%; " border="1">';
        $strListBody .= '<tbody>';
        $strListBody .= '<tr>';

        $SCondition = "  user_shopping_cart_id = $cart_id  and Enabled != 0  and (status = 'bought' or status = 'preparation' or  packing_number is null) ";
        foreach ($objORM->FetchAll($SCondition, '*', ViewIWUserCart) as $ListItem2) {


            $obj_product = $objORM->Fetch("id = $ListItem->api_products_id", "*", TableIWAPIProducts);
            $objShippingTools = new ShippingTools((new MySQLConnection($objFileToolsDBInfo))->getConn());

            if ($objShippingTools->FindItemWeight($obj_product) == -1) {
                $product_weight = 2;
                $objORM->DataUpdate("id = $ListItem->api_products_id", " NoWeightValue = 1 ", TableIWAPIProducts);
            } else {

                $product_weight = $objShippingTools->FindItemWeight($obj_product);
            }


            $objArrayImage = explode("==::==", $ListItem2->images);
            $strListBody .= '<td style="margin:5px; padding:5px; text-align: center;"><a class="pimagemodalclass" href="#PImageModal" data-toggle="modal" data-img-url="' . $objShowFile->FileLocation("attachedimage") . @$objArrayImage[0] . '"> <i class="fa fa-search-plus fa-lg"></i> </a><input type="checkbox" class="flat child "  value="' . $ListItem2->invoice_id . '"   name="ImageSelected[' . $ListItem->user_shopping_cart_id . '][]"><label for="' . $intIdMaker . '" >' . $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[0], $ListItem2->product_id, 120, 'id="myImg" class="cursor_pointer"') . '</label></td>';
            $strListBody .= '<td style="margin:5px; padding:5px; text-align: center;">';
            $strListBody .= '<br><b>' . FA_LC["price"] . ' : ' . $ListItem2->price . '  </b>';
            $strListBody .= '<br><b>' . FA_LC["size"] . ' : ' . $ListItem2->size_text . '  </b>';
            $strListBody .= '<br><b>' . FA_LC["product_code"] . ' : ' . $ListItem2->product_code . '  </b>';
            $strListBody .= '<br><b>' . FA_LC["weight"] . ' : ' . $product_weight . '  </b>';
            $strListBody .= '<br><b>' . $ListItem2->user_name . '  </b></td>';
            $intProductIn++;
            $strListBody .= '<input name="AllProduct[]" value="' . $ListItem2->invoice_id . '" type="hidden">';

            $all_weight_pack += $product_weight;


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