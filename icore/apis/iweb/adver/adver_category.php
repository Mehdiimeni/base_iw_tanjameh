<?php
require_once "../global/CommonInclude.php";


if (!empty($_POST['gender'])) {

    $gender = strtolower($_POST['gender']);
    $condition_statement = "  1 ORDER BY rand() ASC limit 16 ";
    if ($objORM->DataExist($condition_statement, TableIWApiProductType, 'id')) {
        echo @$objORM->FetchJsonWhitoutCondition(TableIWApiProductType, $condition_statement, '*');
    } else {
        echo false;
    }
} else {
    echo false;
}