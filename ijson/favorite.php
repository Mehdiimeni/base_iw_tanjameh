<?php

require_once "../iweb/core/api.php";
function set_server()
{
  $_SERVER['HTTP_HOST'] != 'localhost' ? $server_address = 'https://' . $_SERVER['HTTP_HOST'] : $server_address = $_SERVER['HTTP_HOST'];

  $objIAPI = new IAPI($server_address, 'iweb');
  $objIAPI->SetLocalProjectName('tanjameh');
  return $objIAPI;
}

if (isset($_POST['add_to_favorites'])) {

  $item_id = $_POST['product_id'];
  $look_id = @$_POST['look_id'];
  $company_id = $_POST['company_id'];
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

  echo (($objIAPI->GetPostApi('user/favorite', $filds)));
}


if (isset($_POST['remove_from_favorites'])) {


  $item_id = $_POST['product_id'];
  $look_id = @$_POST['look_id'];
  $company_id = $_POST['company_id'];
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

  echo (($objIAPI->GetPostApi('user/favorite', $filds)));
}
?>