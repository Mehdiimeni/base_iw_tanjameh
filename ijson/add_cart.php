<?php

require_once "../iweb/core/api.php";
function set_server()
{
  $_SERVER['HTTP_HOST'] != 'localhost' ? $server_address = 'https://' . $_SERVER['HTTP_HOST'] : $server_address = $_SERVER['HTTP_HOST'];

  $objIAPI = new IAPI($server_address, 'iweb');
  $objIAPI->SetLocalProjectName('tanjameh');
  return $objIAPI;
}

if (isset($_POST['add_to_cart'])) {

    /*
    $product_id = $_POST['product_id'];
    if (isset($_COOKIE['cart_items'])) {
        $cart_items = json_decode($_COOKIE['cart_items'], true);
    } else {
        $cart_items = array();
    }

    if (!in_array($product_id, $cart_items) and ($product_id != "false") and ($product_id != "true") and ($product_id != "")) {
        array_push($cart_items, $product_id);
        $cart_items = array_unique($cart_items);
        if (count($cart_items) > 50) {
            array_shift($cart_items);
        }
    }


    setcookie('cart_items', json_encode($cart_items), time() + 36000, '/');
    */

    $item_id = @$_POST['product_id'];
    $look_id = @$_POST['look_id'];
    $company_id = @$_POST['company_id'];
    $user_id = @$_POST['user_id'];
    $lounge_id = @$_POST['lounge_id'];
    $session_id = @$_POST['session_id'];


    $filds = array(
      'user_id' => $user_id,
      'item_id' => $item_id,
      'look_id' => $look_id,
      'company_id' => $company_id,
      'lounge_id' => $lounge_id,
      'session_id' => $session_id,
    );
    $objIAPI = set_server();
  
    echo ($objIAPI->GetPostApi('user/add_cart', $filds));
}