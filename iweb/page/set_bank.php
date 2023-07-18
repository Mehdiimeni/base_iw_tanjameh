<?php
//web index 

$_SESSION['page_name_system'] = 'set_bank';

(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'top_checkou');
(new FileCaller)->FileIncluderWithControler('./iweb', 'user', 'set_bank', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'down_checkou');