<?php
///controller/product/product.php

function get_product_info($item)
{
    $filds = array(
        'item' => $item,
        'currencies_conversion_id' => get_currency()
    );

    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('product/product', $filds));

}

// last item view

if(isset($_GET['item'])){
  $product_id = $_GET['item'];
  
  if(isset($_COOKIE['last_viewed_items'])){
    $last_viewed_items = json_decode($_COOKIE['last_viewed_items'], true);
  } else {
    $last_viewed_items = array();
  }

  if (!in_array($product_id, $last_viewed_items)) {

    array_push($last_viewed_items, $product_id);
    $last_viewed_items = array_unique($last_viewed_items);
    if (count($last_viewed_items) > 15) {
      array_shift($last_viewed_items);
    }
  }
  
  setcookie('last_viewed_items', json_encode($last_viewed_items), time()+36000, '/');
}
