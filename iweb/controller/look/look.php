<?php
///controller/look/look.php
function get_look_info($gender, $category, $group)
{
    $filds = array('gender' => $gender, 'category' => $category, 'group' => $group);
    $objIAPI = set_server();

    return json_decode($objIAPI->GetPostApi('look/look_main', $filds));

}




function look_details($gender, $page_condition)
{
    $objIAPI = set_server();

    $filds = array(
         'page_condition' => $page_condition,
          'MainUrl' => $objIAPI->MainUrl, 
          'LocalName' => $objIAPI->LocalName,
          'gender' => $gender
        );

    return json_decode($objIAPI->GetPostApi('product/look_details', $filds));
}

function look_paging($limit, $total, $actual_link)
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