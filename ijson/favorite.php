<?php
if (isset($_POST['add_to_favorites'])) {
  $product_id = $_POST['product_id'];
  // 1. چک کردن وجود کوکی
  if (isset($_COOKIE['favorite_items'])) {
    $favorite_items = json_decode($_COOKIE['favorite_items'], true);
  } else {
    $favorite_items = array();
  }

  if (!in_array($product_id, $favorite_items)) {
    array_push($favorite_items, $product_id);
    $favorite_items = array_unique($favorite_items);
    if (count($favorite_items) > 15) {
      array_shift($favorite_items);
    }
  }


  // 3. ذخیره کردن آرایه favorite_items در کوکی با نام favorite_items
  setcookie('favorite_items', json_encode($favorite_items), time() + 36000, '/');
}


if (isset($_POST['remove_from_favorites'])) {
  $id_to_remove = $_POST['product_id'];
  // 1. چک کردن وجود کوکی
  if (isset($_COOKIE['favorite_items'])) {
    $favorite_items = json_decode($_COOKIE['favorite_items'], true);
    $index = array_search($id_to_remove, $favorite_items);
    if ($index !== false) {
      unset($favorite_items[$index]);
      $favorite_items = array_values($favorite_items);
      setcookie('favorite_items', json_encode($favorite_items), time() + 36000, '/');
    }
  }
}
?>