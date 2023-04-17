<?php

if (isset($_POST['SubmitAddData'])) {

    if ($_POST['Key'] != '') {
        $strKey = trim($_POST['Key']);
        $strKey = str_replace(' ', '', $strKey);
        $strKey = preg_replace('/\s+/', '', $strKey);

        $FOpen = fopen($this->DefineRoot . 'conf/key.iw', 'x');
        fwrite($FOpen, "$strKey\n");
        fclose($FOpen);
    }
    echo('<meta http-equiv="refresh" content="0;URL=">');

}

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>IW Key</title>
</head>

<body>
<form id="form1" name="form1" method="post">
    <p>
        <label for="textarea">IW Key </label>
        <br/>
        <textarea name="Key" rows="3" cols="100" id="textarea"></textarea>
    </p>
    <p>
        <input type="reset" name="reset" id="reset" value="Reset">
        <input type="submit" name="SubmitAddData" id="submit" value="Submit">
    </p>
</form>
</body>
</html>
