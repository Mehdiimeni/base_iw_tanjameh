<?php
//web index 

$_SESSION['page_name_system'] = 'checkout_address';

(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'top_checkou');
(new FileCaller)->FileIncluderWithControler('./iweb', 'user', 'checkout_address', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'down_checkou');
