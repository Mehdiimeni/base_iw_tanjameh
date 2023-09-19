<?php
require_once "../global/CommonInclude.php";


if (!empty($_POST['gender'])) {

    $gender = strtolower($_POST['gender']);
    $condition_statement = "  1 ORDER BY rand() ASC limit 16 ";
    if ($objORM->DataExist($condition_statement, TableIWApiBrands, 'id')) {
        echo @$objORM->FetchJsonWhitoutCondition(TableIWApiBrands, $condition_statement, '*');
    } else {
        echo false;
    }
} else {
    echo false;
}