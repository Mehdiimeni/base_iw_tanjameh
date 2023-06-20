<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../../iassets/include/DBLoader.php";


if (isset($_POST['cat_id'])) {

    $cat_id = $_POST['cat_id'];
    $gender = $_POST['gender'];
    $category = $_POST['category'];
    $group = $_POST['group'];

    $condition = "CatId = '$cat_id' and Name = '$group' and Enabled = 1 ";
    $obj_row_menu3 = @$objORM->Fetch($condition, "IdRow,Name,LocalName", TableIWNewMenu3);

    $condition = " Name = '$category' and Enabled = 1 ";
    $obj_row_menu2 = @$objORM->Fetch($condition, "IdRow,Name,LocalName", TableIWNewMenu2);

    $condition = " Name = '$gender' and Enabled = 1 ";
    $obj_row_menu = @$objORM->Fetch($condition, "IdRow,Name,LocalName", TableIWNewMenu);


    $arr_row_menu = array('gender_name' => $obj_row_menu->Name, 'gender_local_name' => $obj_row_menu->LocalName, 'gender_id_row' => $obj_row_menu->IdRow);
    $arr_row_menu2 = array('category_name' => $obj_row_menu2->Name, 'category_local_name' => $obj_row_menu2->LocalName, 'category_id_row' => $obj_row_menu2->IdRow);
    $arr_row_menu3 = array('group_name' => $obj_row_menu3->Name, 'group_local_name' => $obj_row_menu3->LocalName, 'group_id_row' => $obj_row_menu3->IdRow);
    $arr_group_detials = array_merge($arr_row_menu, $arr_row_menu2, $arr_row_menu3);
    echo json_encode($arr_group_detials);

}