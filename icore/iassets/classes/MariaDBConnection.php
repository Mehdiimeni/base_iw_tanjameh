<?php
require_once "iassets/interfaces/DBConnectionInterface.php";

final class MariaDBConnection implements DBConnectionInterface
{
    public function connect()
    {
        echo "maria";
    }
}
