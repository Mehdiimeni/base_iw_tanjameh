<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../../iassets/include/DBLoader.php";


if (!empty($_POST['brand'])) {

    $brand = str_replace('%20', ' ',$_POST['brand']);
    $brand_id= $_POST['id'];

    $condition = " id = '$brand_id' ";
    $obj_brand = $objORM->Fetch($condition, '*', TableIWApiBrands);


    $condition = " Enabled = 1 AND Content IS NOT NULL
    AND AdminOk = 1 AND iw_api_brands_id = $brand_id ";
    $total_en = @$objORM->DataCount($condition, TableIWAPIProducts);

    $last_page = ceil($total_en / 15);

    $last_page_fa = $objGlobalVar->NumberFormat($last_page, 0, ".", ",");
    $last_page_fa = $objGlobalVar->Nu2FA($last_page_fa);

    $total = $objGlobalVar->NumberFormat($total_en, 0, ".", ",");
    $total = $objGlobalVar->Nu2FA($total);

    $brand_description = $objGlobalVar->CleanStr($obj_brand->description);
    $arr_product_total = array(
        'total' => $total,
        'total_en' => $total_en,
        'last_page' => $last_page,
        'last_page_fa' => $last_page_fa,
        'brand_name' => $obj_brand->name,
        'brand_description' => $brand_description
    );

    $arr_group_detials = array_merge(
        $arr_product_total
    );

    echo json_encode($arr_group_detials);
} else {
    echo false;
}