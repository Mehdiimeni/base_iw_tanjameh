<?php
require_once "../global/CommonInclude.php";

// تعداد محصولات در هر صفحه
$itemsPerPage = 100;

// محاسبه صفحه فعلی
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;

$condition = " Enabled = 1 AND Content IS NOT NULL AND AdminOk = 1 order by last_modify  DESC LIMIT $offset, $itemsPerPage";
if ($objORM->DataExist($condition, TableIWAPIProducts, 'id')) {
    $obj_products = @$objORM->FetchAll(
        $condition,
        "id,url_gender,url_category,url_group,isInStock",
        TableIWAPIProducts
    );



    foreach ($obj_products as $product) {

        $argument = "$product->id,1";
        $CarentCurrencyPrice = (float) @$objORM->FetchFunc($argument, FuncIWFuncPricing)[0]->Result;
        $PreviousCurrencyPrice = (float) @$objORM->FetchFunc($argument, FuncIWFuncLastPricing)[0]->Result;


        $boolChange = 0;

        if (($CarentCurrencyPrice < $PreviousCurrencyPrice) and $PreviousCurrencyPrice > 0)
            $boolChange = 1;



        if ($CarentCurrencyPrice != null) {
            $CarentCurrencyPrice = $objGlobalVar->NumberFormat($CarentCurrencyPrice, 0, ".", ",");
        }
        $PreviousCurrency = 0;

        if ($boolChange) {
            $PreviousCurrency = $objGlobalVar->NumberFormat($PreviousCurrencyPrice, 0, ".", ",");
        }

        if ($product->isInStock == 1) {
            $availability = 'instock';
        } else {
            $availability = '';
        }


        $product_page_url = "https://tanjameh.com?gender=" . urlencode($product->url_gender) . "&category=" . urlencode($product->url_category) . "&group=" . urlencode($product->url_group) . "&item=" . $product->id;

        $arr_product_detail[] = array(
            'product_id' => $product->id,
            'page_url' => $product_page_url,
            'price' => $CarentCurrencyPrice,
            'availability' => $availability,
            'old_price' => $PreviousCurrency

        );

    }

    echo json_encode($arr_product_detail);
} else {
    echo ("No products found");
}