<?php
///controller/product/group.php

function get_group_info($cat_id, $gender, $category, $group)
{
    $filds = array('cat_id' => $cat_id, 'gender' => $gender, 'category' => $category, 'group' => $group);
    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('product/group', $filds));

}

function group_product_details($cat_id, $page_condition)
{
    $objIAPI = set_server();

    $filds = array('cat_id' => $cat_id, 'page_condition' => $page_condition, 'MainUrl' => $objIAPI->MainUrl, 'LocalName' => $objIAPI->LocalName);
    return json_decode($objIAPI->GetPostApi('product/group_product_details', $filds));
}

function group_product_paging($limit, $total)
{
    $pages = ceil((int) $total / $limit);
    $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
        'options' => array(
            'default' => 1,
            'min_range' => 1,
        ),
    )
    ));

    $offset = ($page - 1) * $limit;

    $start = $offset + 1;
    $end = min(($offset + $limit), $total);

    // The "back" link
    $prevlink = ($page > 1) ? '<a href="?page=1" title="First page">&laquo;</a> <a href="?page=' . ($page - 1) . '" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';

    // The "forward" link
    $nextlink = ($page < $pages) ? '<a href="?page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a href="?page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';

    // Display the paging information
    echo $prevlink . ' Page ' . $page . ' of ' . $pages . ' pages, displaying ' . $start . '-' . $end . ' of ' . $total . ' results ' . $nextlink;
    /*
        <li class="page-item ">
                <a class="page-link border-0 bg-white text-body-tertiary"><i class="fa-solid fa-chevron-right"></i></a>
              </li>
              <li class="page-item d-flex align-items-center mx-4"></li>
              <li class="page-item">
                <a class="page-link border-0 text-reset" href="#"><i class="fa-solid fa-chevron-left"></i></a>
              </li>
              */
}