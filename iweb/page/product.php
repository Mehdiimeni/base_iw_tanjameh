<?php
//web group 
require("./iweb/core/code_cacher.php");
$_SESSION['item'] = $_GET['item'];
$_SESSION['page_name_system'] = 'product';



(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'top_product');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'top');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'nav');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'menu');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'mobile_view');
$codeCacher = new CodeCacher();
$codeKey = $_SESSION['page_name_system'].$_SESSION['item'] ;
$cachedCode = $codeCacher->getCachedCode($codeKey);

if ($cachedCode === false) {
    ob_start();
(new FileCaller)->FileIncluderWithControler('./iweb', 'product', 'product', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'related_adver_1', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'related_adver_2', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'related_adver_3', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'brand_box', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'trend_categories', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'footer');
(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'down_product');

$codeContent = ob_get_clean();
$codeCacher->cacheCode($codeKey, $codeContent);
$cachedCode = $codeCacher->getCachedCode($codeKey);

echo $cachedCode;
} else {
echo $cachedCode;
}