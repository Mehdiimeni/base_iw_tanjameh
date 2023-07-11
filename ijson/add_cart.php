<?php
if (isset($_POST['add_to_cart'])) {
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
}