<?php
///controller/product/category.php

function get_category_info($gender, $category)
{
    $filds = array('gender' => $gender, 'category' => $category);
    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('product/category', $filds));

}

function category_product_details($gender, $category, $page_condition)
{
    $objIAPI = set_server();

    $filds = array(
         'page_condition' => $page_condition,
          'MainUrl' => $objIAPI->MainUrl, 
          'LocalName' => $objIAPI->LocalName,
          'gender' => $gender,
          'category' => $category,
          'currencies_conversion_id' => get_currency()
        );

    return json_decode($objIAPI->GetPostApi('product/category_product_details', $filds));
}

function category_product_paging($limit, $total, $actual_link)
{
    $pages = ceil((int) $total / $limit);
    $page = min($pages, filter_input(
        INPUT_GET,
        'page',
        FILTER_VALIDATE_INT,
        array(
            'options' => array(
                'default' => 1,
                'min_range' => 1,
            ),
        )
    )
    );

    $offset = ($page - 1) * $limit;

 

    $start = $offset + 1;
    $end = min(($offset + $limit), $total);


    // The "back" link
    $prevlink = ($page > 1) ? '<li class="page-item "> <a href="'.$actual_link.'&page=1" class="page-link border-0 bg-white text-body-tertiary"><i class="fa-solid fa-chevron-right"></i></a></li>
    <li class="page-item "><a href="'.$actual_link.'&page=' . ($page - 1) . '" class="page-link border-0 bg-white text-body-tertiary"><i class="fa-solid fa-chevron-right"></i></a></li>
    ' : '<li class="page-item disabled"><a class="page-link border-0 bg-white text-body-tertiary"><i class="fa-solid fa-chevron-right"></i></a></li>';

    // The "forward" link
    $nextlink = ($page < $pages) ? '<li class="page-item"><a href="'.$actual_link.'&page=' . ($page + 1) . '" class="page-link border-0 text-reset" ><i class="fa-solid fa-chevron-left"></i></a></li>
    <li class="page-item"><a href="'.$actual_link.'&page=' . $pages . '" class="page-link border-0 text-reset" ><i class="fa-solid fa-chevron-left"></i></a></li>' : '<li class="page-item disabled"><a class="page-link border-0 bg-white text-body-tertiary"><i class="fa-solid fa-chevron-right"></i></a></li>';

    // Display the paging information
    echo $prevlink .' '. _LANG["page"] .' '. $page .' '. _LANG["of"] .' '. $pages .' '. _LANG["page"].' , '._LANG["displaying"] .' '. $start . '-' . $end .' '. _LANG["of"] .' '. $total .' '. _LANG["results"] . $nextlink;

}