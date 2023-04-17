<?php
// DataLoader.php
if (isset($_GET['loaddata'])) {

    include "./controller/GlobalPage/NewProductCatch.php";
    include "./controller/GlobalPage/NewProductCatch2.php";

    include_once "./controller/GlobalPage/ClearDB.php";
}
