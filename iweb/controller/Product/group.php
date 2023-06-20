<?php
///controller/product/group.php

function get_group_info($cat_id, $gender, $category, $group)
{
    $filds = array('cat_id' => $cat_id, 'gender' => $gender, 'category' => $category, 'group' => $group);
    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('product/group', $filds));

}

function group_product_details($cat_id,$page_condition)
{
    $objIAPI = set_server();
    
    $filds = array('cat_id' => $cat_id,'page_condition'=> $page_condition, 'MainUrl'=>$objIAPI->MainUrl , 'LocalName'=>$objIAPI->LocalName );
    return json_decode($objIAPI->GetPostApi('product/group_product_details', $filds));
}