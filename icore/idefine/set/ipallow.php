<?php

if (isset($_POST['SubmitAddData'])) {

    $strListIPAllow = trim($_POST['IPAllow']);
    $strListIPAllow = str_replace(' ', '', $strListIPAllow);
    $strListIPAllow = preg_replace('/\s+/', '', $strListIPAllow);

    $FOpen = fopen($this->DefineRoot . 'conf/ipallow.txt', 'x');

    foreach (explode(";", $strListIPAllow) as $ListIPAllow) {

        fwrite($FOpen, "$ListIPAllow\n");

    }

    fclose($FOpen);

    echo('<meta http-equiv="refresh" content="0;URL=">');
}

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>IW IP Allow</title>
</head>

<body>
<form id="form1" name="form1" method="post">
    <p>
        <label for="textarea">IW IP Allow (;) - all is defult</label>
        <br/>
        <textarea name="IPAllow" rows="3" cols="100" id="textarea">all</textarea>
    </p>
    <p>
        <input type="reset" name="reset" id="reset" value="Reset">
        <input type="submit" name="SubmitAddData" id="submit" value="Submit">
    </p>
</form>
</body>
</html>
