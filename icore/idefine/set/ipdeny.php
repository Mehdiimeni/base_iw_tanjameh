<?php
if (isset($_POST['SubmitAddData'])) {

    $strListIPDeny = trim($_POST['IPDeny']);
    $strListIPDeny = str_replace(' ', '', $strListIPDeny);
    $strListIPDeny = preg_replace('/\s+/', '', $strListIPDeny);

    $FOpen = fopen($this->DefineRoot . 'conf/ipdeny.txt', 'x');

    foreach (explode(";", $strListIPDeny) as $ListIPDeny) {

        fwrite($FOpen, "$ListIPDeny\n");

    }

    fclose($FOpen);

    echo('<meta http-equiv="refresh" content="0;URL=">');
}

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>IW IP Deny</title>
</head>

<body>
<form id="form1" name="form1" method="post">
    <p>
        <label for="textarea">IW IP Deny (;) - any is defult</label>
        <br/>
        <textarea name="IPDeny" rows="3" cols="100" id="textarea">any</textarea>
    </p>
    <p>
        <input type="reset" name="reset" id="reset" value="Reset">
        <input type="submit" name="SubmitAddData" id="submit" value="Submit">
    </p>
</form>
</body>
</html>
