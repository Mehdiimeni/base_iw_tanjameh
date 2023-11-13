<?php
require_once "../global/CommonInclude.php";


if (!empty($_POST['search'])) {

    $search = str_replace('%20', ' ', $_POST['search']);

    $condition = " name LIKE '%$search%' ";
    $obj_type_id = @$objORM->Fetch($condition, 'id', TableIWApiProductType)->id;
    $obj_brand_id = @$objORM->Fetch($condition, 'id', TableIWApiBrands)->id;

    if (!empty($obj_type_id)) {
        $condition = " Enabled = 1 AND Content IS NOT NULL
    AND AdminOk = 1 AND ( iw_api_product_type_id = $obj_type_id)  ";
    } elseif (!empty($obj_brand_id)) {

        $condition = " Enabled = 1 AND Content IS NOT NULL
    AND AdminOk = 1 AND iw_api_brands_id = $obj_brand_id";

    } elseif (!empty($obj_type_id) and !empty($obj_type_id)) {

        $condition = " Enabled = 1 AND Content IS NOT NULL
    AND AdminOk = 1 AND ( iw_api_product_type_id = $obj_type_id or iw_api_brands_id = $obj_brand_id )";

    } else {

        $condition = " Enabled = 1 AND Content IS NOT NULL
        AND AdminOk = 1 and Name LIKE '%$search%' ";

    }

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
        'last_page_fa' => $last_page_fa,
        'search_name' => $search,

    );

    $arr_group_detials = array_merge(
        $arr_product_total
    );

    echo json_encode($arr_group_detials);
} else {
    echo false;
}