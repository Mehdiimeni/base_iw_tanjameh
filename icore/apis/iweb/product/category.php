<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../../iassets/include/DBLoader.php";


if (!empty($_POST['category'])) {

    $gender = urldecode($_POST['gender']);
    $category = urldecode($_POST['category']);


    $condition = " Name = '$category' and Enabled = 1 ";

    if ($objORM->DataExist($condition, TableIWNewMenu2, 'id')) {
        $obj_row_menu2 = @$objORM->Fetch($condition, "id,Name,LocalName", TableIWNewMenu2);

        $condition = " Name = '$gender' and Enabled = 1 ";
        if ($objORM->DataExist($condition, TableIWNewMenu, 'id')) {
            $obj_row_menu = @$objORM->Fetch($condition, "id,Name,LocalName", TableIWNewMenu);

            $condition = "   url_gender = '$gender' and url_category = '$category' and Enabled = 1 AND Content IS NOT NULL AND AdminOk = 1   ";

            $total_en = @$objORM->DataCount($condition, TableIWAPIProducts);

            $last_page = ceil($total_en / 15);

            $last_page_fa = $objGlobalVar->NumberFormat($last_page, 0, ".", ",");
            $last_page_fa = $objGlobalVar->Nu2FA($last_page_fa);

            $total = $objGlobalVar->NumberFormat($total_en, 0, ".", ",");
            $total = $objGlobalVar->Nu2FA($total);
            $arr_product_total = array(
                'total' => $total,
                'total_en' => $total_en,
                'last_page' => $last_page,
                'last_page_fa' => $last_page_fa
            );

            $arr_row_menu = array(
                'gender_name' => $obj_row_menu->Name,
                'gender_local_name' => $obj_row_menu->LocalName,
                'gender_id_row' => $obj_row_menu->id
            );

            $arr_row_menu2 = array(
                'category_name' => $obj_row_menu2->Name,
                'category_local_name' => $obj_row_menu2->LocalName,
                'category_id_row' => $obj_row_menu2->id
            );



            $arr_category_detials = array_merge(
                $arr_row_menu,
                $arr_row_menu2,
                $arr_product_total
            );

            echo json_encode($arr_category_detials);
        } else {
            echo false;
        }
    } else {
        echo false;
    }


} else {
    echo false;
}