<?php
///controller/product/product.php

function get_product_info($item)
{
    $filds = array('item' => $item);
    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('product/product', $filds));

}