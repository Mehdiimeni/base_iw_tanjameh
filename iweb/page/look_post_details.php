<?php
//web index 

$_SESSION['page_name_system'] = 'look_post_details';

(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'top_product');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'top');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'nav');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'menu');
(new FileCaller)->FileIncluderWithControler('./iweb', 'look', 'look_post_details', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'look', 'look_post_like', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'brand_box', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'trend_categories', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'footer');
(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'down_product');